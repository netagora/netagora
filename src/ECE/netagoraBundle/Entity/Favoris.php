<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Favoris
 */
class Favoris
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     private $id;

    /**
     * @var string $publication
     */
    private $publication;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set publication
     *
     * @param string $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * Get publication
     *
     * @return string 
     */
    public function getPublication()
    {
        return $this->publication;
    }
}