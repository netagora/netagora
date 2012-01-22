<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class PublicationRepository extends EntityRepository
{
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
            ->addWhere('p.id = :id')
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
            ->getUserPublicationQueryBuilder($user);
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
            ->addWhere('u.id = :user_id')
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
            ->addWhere('c.type = :type')
            ->orderBy('p.publishedAt', 'desc')
            ->setParameter('user_id', $user)
            ->getQuery()
        ;

        return $q->getResult();
    }
}