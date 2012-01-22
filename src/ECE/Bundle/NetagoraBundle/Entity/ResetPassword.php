<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

class ResetPassword
{
    private $password;

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}