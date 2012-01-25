<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Aggbox
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var User $user
     */
    private $user;
    
    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $content
     */
    private $content;
    
    /**
     * @var datetime $submitDate
     */
    private $submitDate;
    
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
     * Set user
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set submitDate
     *
     * @param datetime $submitDate
     */
    public function setSubmitDate(\DateTime $date)
    {
        $this->submitDate = $date;
    }

    /**
     * Get submitDate
     *
     * @return datetime 
     */
    public function getSubmitDate()
    {
        return $this->submitDate;
    }
    
    
    
}