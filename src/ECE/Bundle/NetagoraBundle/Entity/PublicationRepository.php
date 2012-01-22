<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationRepository extends EntityRepository
{
    public function getVideoPublications($user_id)
    {
        return $this->getByCategoryType('Video', $user_id);
    }

    public function getMusicPublications($user_id)
    {
        return $this->getByCategoryType('Music', $user_id);
    }

    private function getByCategoryType($type, $user_id)
    {
        $q = $this
            ->createQueryBuilder('p')
            ->select('p, l, c')
            ->leftJoin('p.knownLink', 'l')
            ->leftJoin('l.category', 'c')
            ->leftJoin('p.user', 'u')
            ->where('c.type = :type')
            ->andWhere('u.id = :user_id')
            ->orderBy('p.publishedAt', 'desc')
            ->setParameter('type', $type)
            ->setParameter('user_id', $user_id)
            ->getQuery()
        ;
        return $q->getResult();
    }
}