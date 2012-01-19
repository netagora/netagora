<?php

namespace ECE\Bundle\BetaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ECE\Bundle\BetaBundle\Entity\Emailing
 */
class Emailing
{
    /**
     * @var integer $id
     */
    private $id;
    
    /**
     * @var string $email
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}