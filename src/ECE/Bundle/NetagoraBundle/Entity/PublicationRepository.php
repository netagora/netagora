<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Buzz\Browser;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use ECE\Bundle\NetagoraBundle\AI\CategoryGuesser;
use ECE\Bundle\NetagoraBundle\Entity\KnownLink;
use ECE\Bundle\NetagoraBundle\Entity\KnownLinkRepository;
use Symfony\Component\DomCrawler\Crawler;

class PublicationRepository extends EntityRepository
{
    private $browser;

    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    // Check de l'url dans la table known link
    // Si déjà utilisée, on affecte le KnownLink dans la publication
    // Sinon on crée un nouveau KnowLink
    //      -> on lance le CategoryGuesser
    //      -> on trouve la catégorie associé au KnownLink
    //      -> on remplit le KnownLink
    //      -> on persiste et flush la publication
    public function save(array $publications)
    {
        if (0 === count($publications)) {
            return;
        }

        $repository = $this->_em->getRepository('ECENetagoraBundle:KnownLink');

        $references = $this->getExistingReferences($publications);

        foreach ($publications as $publication) {
            if (!in_array($publication->getReference(), $references)) {

                // Scrap the publication and get the latest uri
                try {
                    $response = $this->browser->get($publication->getLinkUrl());
                } catch (\Exception $e) {
                    // The Http request failed...
                    continue;
                }
                
                $urls = explode("\n", $response->getHeader('Location'));
                $url = array_pop($urls);

                $knownLink = $this
                    ->_em
                    ->getRepository('ECENetagoraBundle:KnownLink')
                    ->findOneByUrl($url)
                ;

                // We found a corresponding KnownLink that we can affect to the publication
                if ($knownLink) {
                    $publication->setKnownLink();
                    $this->_em->persist($publication);
                    continue;
                }

                // Otherwise, we need to create a new KnownLink and guess the category
                $crawler = new Crawler();
                $crawler->addContent($response->getContent());
                $guesser = new CategoryGuesser($url, $response, $crawler);
                $guesser->guess();

                $category = $this
                    ->_em
                    ->getRepository('ECENetagoraBundle:Category')
                    ->findOneByType($guesser->getCategory())
                ;

                /*if (null === $category) {
                    var_dump($guesser->getScores());die;
                    echo $guesser->getCategory();die;
                }*/

                $knownLink = new KnownLink();
                $knownLink->setCategory($category);
                $knownLink->setUrl($url);
                $knownLink->fromArray($guesser->getMetadata());
                $publication->setKnownLink($knownLink);

                $this->_em->persist($knownLink);
                $this->_em->persist($publication);
            }
        }

        $this->_em->flush();
    }

    private function getExistingReferences(array $publications)
    {
        $references = array();
        foreach ($publications as $publication) {
            $references[] = $publication->getReference();
        }

        $q = $this
            ->createQueryBuilder('p')
            ->select('p.id', 'p.reference')
            ->where('p.reference IN(:references)')
            ->groupBy('p.reference')
            ->setParameter('references', $references)
            ->getQuery()
        ;

        $references = array();
        foreach ($q->getResult(Query::HYDRATE_ARRAY) as $result) {
            $references[] = $result['reference'];
        }

        return $references;
    }

    /**
     * Returns the Video publications of a single user.
     *
     * @param integer $user The user identifier
     * @return Publication[] A collection of publications
     */
    public function getVideoPublications($user)
    {
        return $this->getByCategoryType('Video', $user);
    }

    /**
     * Returns the Music publications of a single user.
     *
     * @param integer $user The user identifier
     * @return Publication[] A collection of publications
     */
    public function getMusicPublications($user)
    {
        return $this->getByCategoryType('Music', $user);
    }
    
    /**
     * Returns the Photo publications of a single user.
     *
     * @param integer $user The user identifier
     * @return Publication[] A collection of publications
     */
    public function getPhotoPublications($user)
    {
        return $this->getByCategoryType('Photo', $user);
    }
    
    /**
     * Returns the Location publications of a single user.
     *
     * @param integer $user The user identifier
     * @return Publication[] A collection of publications
     */
    public function getLocationPublications($user)
    {
        return $this->getByCategoryType('Location', $user);
    }

    /**
     * Returns a Publication instance related to a single user.
     *
     * @param integer $id   The publication identifier
     * @param integer $user The user identifier
     * @return Publication|Boolean $publication The found publication or false
     */
    public function getOwnerPublication($id, $user)
    {
        $q = $this
            ->getUserPublicationQueryBuilder($user)
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        try {
            return $q->getSingleResult();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns the last fetched publication from a social service.
     *
     * @param integer $user The user identifier
     * @return Publication|Boolean The found publication or false
     */
    public function getLastPublication($user)
    {
        $q = $this
            ->getUserPublicationQueryBuilder($user)
            ->orderBy('p.reference', 'desc')
            ->setMaxResults(1)
            ->getQuery()
        ;

        try {
            return $q->getSingleResult();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns the QueryBuilder instance that contains the criteria to fetch
     * publications related to a single user.
     *
     * @param integer       $user The user identifier
     * @param QueryBuilder  $qb   An already initialized QueryBuilder or null
     * @return QueryBuilder $qb   The QueryBuilder
     */
    private function getUserPublicationQueryBuilder($user, QueryBuilder $qb = null)
    {
        if (null === $qb) {
            $qb = $this->createQueryBuilder('p');
        }

        $qb = $this
            ->createQueryBuilder('p')
            ->select('p, l, c')
            ->leftJoin('p.knownLink', 'l')
            ->leftJoin('l.category', 'c')
            ->leftJoin('p.user', 'u')
            ->where('u.id = :user_id')
            ->setParameter('user_id', $user)
        ;

        return $qb;
    }

    /**
     * Returns the publications of a single user for a specific category.
     *
     * @param string  $type The publications category name
     * @param integer $user The user identifier
     * @return Publication[] A collection of publications
     */
    private function getByCategoryType($type, $user)
    {
        $q = $this
            ->getUserPublicationQueryBuilder($user)
            ->andWhere('c.type = :type')
            ->orderBy('p.publishedAt', 'desc')
            ->setParameter('type', $type)
            ->getQuery()
        ;

        return $q->getResult();
    }
}