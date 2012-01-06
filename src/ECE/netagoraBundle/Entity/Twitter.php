<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Twitter
 */
class Twitter
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
     * @var string $token
     */
    private $token;

    /**
     * @var integer $twitter_id
     */
    private $twitter_id;


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
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set twitter_id
     *
     * @param integer $twitterId
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;
    }

    /**
     * Get twitter_id
     *
     * @return integer 
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }
}