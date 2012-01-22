<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * PublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationRepository extends EntityRepository
{
    public function getVideoPublications($user)
    {
        return $this->getByCategoryType('Video', $user);
    }

    public function getMusicPublications($user)
    {
        return $this->getByCategoryType('Music', $user);
    }

    public function getOwnerPublication($id, $user)
    {
        $qb = $this->getUserPublicationQueryBuilder($user);

        $q = $qb
            ->addWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        $publication = false;
        try {
            $publication = $q->getSingleResult();
        } catch (\Exception $e) {
            
        }

        return $publication;
    }

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

    private function getByCategoryType($type, $user)
    {
        $qb = $this->getUserPublicationQueryBuilder($user);

        $q = $qb
            ->addWhere('c.type = :type')
            ->orderBy('p.publishedAt', 'desc')
            ->setParameter('user_id', $user)
            ->getQuery()
        ;

        return $q->getResult();
    }
}