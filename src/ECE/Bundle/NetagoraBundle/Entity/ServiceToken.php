<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

/**
 * ECE\Bundle\NetagoraBundle\Entity\ServiceToken
 */
class ServiceToken
{
    private $id;

    /**
     * @var string (facebook or twitter)
     */
    private $type;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var string $token
     */
    private $token;

    /**
     * @var string $data
     */
    private $data;

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

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
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
     * Set data
     *
     * @param string|array $data
     */
    public function setData($data)
    {
        $this->data = serialize($data);
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return unserialize($this->data);
    }
}