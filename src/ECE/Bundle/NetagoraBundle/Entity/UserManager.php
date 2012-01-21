<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    private $em;

    private $class;

    private $repository;

    public function __construct(ObjectManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($class);
    }

    public function updateUser(UserInterface $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function supportsClass($class)
    {
        return $this->repository->supportsClass($class);
    }
}