<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

class AggboxRepository extends EntityRepository
{
    /**
     * Returns the aggbox.
     * @return Aggbox[] A collection of aggbox
     */
    public function getIdeas()
    {
        $q = $this
            ->createQueryBuilder('a')
            ->getQuery()
        ;
        return $q->getResult();
    }
}