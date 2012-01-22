<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

class PasswordRequest
{
    private $id;

    private $username;

    private $email;

    private $token;

    private $expiresAt;

    private $user;

    public function __construct()
    {
        $this->expiresAt = new \DateTime('+1 day');
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        $this->token = md5($username.uniqid().$this->expiresAt->format('U'));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getToken()
    {
        return $this->token;
    }
}