<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

class PublicationRepository extends EntityRepository
{
    public function save(array $publications)
    {
        if (0 === count($publications)) {
            return;
        }

        $references = $this->getExistingReferences($publications);

        foreach ($publications as $publication) {
            if (!in_array($publication->getReference(), $references)) {
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
    
    private function attachCategory()
    {
        /* Initialize score */
        $score = array('image' => 0, 'video' => 0, 'music' => 0, 'location' => 0);

        $url = Publication::lengthener($this->getLinkUrl());

        if (Publication::urlImage($url)) $score['image']++;
        if (Publication::urlVideo($url)) $score['video']++;
        if (Publication::urlMusic($url)) $score['music']++;
        if (Publication::urlMap($url)) $score['location']++;
        if (Publication::testImage($url)) $score['image'] = $score['image']+2;


        $description = Publication::search_description($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($description, $synonyme)) $score['image'] = $score['image']+1;

        $description = Publication::search_description($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if (Publication::compare($description, $synonyme)) $score['video'] = $score['video']+1;

        $description = Publication::search_description($url);
        $synonyme = array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (Publication::compare($description, $synonyme)) $score['music'] = $score['music']+1;

        $description = Publication::search_description($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($description, $synonyme)) $score['location'] = $score['location']+1;

        $type = Publication::search_type($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($type, $synonyme)) $score['image'] = $score['image']+1;

        $type = Publication::search_type($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if (Publication::compare($type, $synonyme)) $score['video'] = $score['video']+1;

        $type = Publication::search_type($url);
        $synonyme = array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (Publication::compare($type, $synonyme)) $score['music'] = $score['music']+1;

        $type = Publication::search_type($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($type, $synonyme)) $score['location'] = $score['location']+1;

        $keyword = Publication::search_keywords($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($keyword, $synonyme)) $score['image'] = $score['image']+1;

        $keyword = Publication::search_keywords($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if (Publication::compare($keyword, $synonyme)) $score['video'] = $score['video']+1;
        
        $keyword = Publication::search_keywords($url);
        $synonyme = array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (Publication::compare($keyword, $synonyme)) $score['music'] = $score['music']+1;

        $keyword = Publication::search_keywords($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($keyword, $synonyme)) $score['location'] = $score['location']+1;

        $title = Publication::search_title($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($title, $synonyme)) $score['image'] = $score['image']+1;

        $title = Publication::search_title($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if (Publication::compare($title, $synonyme)) $score['video'] = $score['video']+1;

        $title = Publication::search_title($url);
        $synonyme = array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (Publication::compare($title, $synonyme)) $score['music'] = $score['music']+1;

        $title = Publication::search_title($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($title, $synonyme)) $score['location'] = $score['location']+1;

        $h1 = Publication::search_h1($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($h1, $synonyme)) $score['image'] = $score['image']+1;
        
        $h1 = Publication::search_h1($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if (Publication::compare($h1, $synonyme)) $score['video'] = $score['video']+1;

        $h1 = Publication::search_h1($url);
        $synonyme=array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (compare($h1, $synonyme)) $score['music'] = $score['music']+1;

        $h1 = Publication::search_h1($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($h1, $synonyme)) $score['location']=$score['location']+1;

        $h2 = Publication::search_h2($url);
        $synonyme = array('#.*image.*#', '#.*img.*#', '#.*photo.*#', '#.*picture.*#');
        if (Publication::compare($h2, $synonyme)) $score['image']=$score['image']+1;

        $h2 = Publication::search_h2($url);
        $synonyme = array('#.*video.*#', '#.*watch.*#', '#.*film.*#', '#.*trailer.*#');
        if(Publication::compare($h2, $synonyme)) $score['video']=$score['video']+1;

        $h2 = Publication::search_h2($url);
        $synonyme = array('#.*music.*#', '#.*musique.*#', '#.*audio.*#', '#.*playlist.*#','#.*chanson.*#', '#.*song.*#', '#.*listen.*#');
        if (Publication::compare($h2, $synonyme)) $score['music']=$score['music']+1;

        $h2 = Publication::search_h2($url);
        $synonyme = array('#.*map.*#', '#.*foursquare\.com.*#', '#.*loopt\.com.*#', '#.*4sqp\.com.*#');
        if (Publication::compare($h2, $synonyme)) $score['location'] = $score['location']+1;
        
        $results = array_keys($score, max($score));
        
        echo '<pre>';
        var_dump($cles);
        echo '</pre>';
        die('end algo');
        

}