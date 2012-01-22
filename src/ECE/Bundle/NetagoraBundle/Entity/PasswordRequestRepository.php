<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PasswordRequestRepository extends EntityRepository
{
    public function getActiveRequest($token)
    {
        $q = $this
            ->createQueryBuilder('r')
            ->select('r, u')
            ->innerJoin('r.user', 'u')
            ->where('r.token = :token')
            ->andWhere('r.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s'))
            ->setParameter('token', $token)
            ->getQuery()
        ;

        $request = false;
        try {
            $request = $q->getSingleResult();
        } catch (\Exception $e) {
            
        }

        return $request;
    }
}