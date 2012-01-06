<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Fb
 */
class Fb
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $user
     */
    private $user;

    /**
     * @var text $token
     */
    private $token;

    /**
     * @var string $fb_id
     */
    private $fb_id;


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
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set token
     *
     * @param text $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return text 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set fb_id
     *
     * @param string $fbId
     */
    public function setFbId($fbId)
    {
        $this->fb_id = $fbId;
    }

    /**
     * Get fb_id
     *
     * @return string 
     */
    public function getFbId()
    {
        return $this->fb_id;
    }
}