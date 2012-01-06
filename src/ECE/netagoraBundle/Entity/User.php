<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\User
 */
class User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $mail
     */
    private $mail;

    /**
     * @var datetime $inscription_date
     */
    private $inscription_date;

    /**
     * @var string $img
     */
    private $img;

    /**
     * @var integer $age
     */
    private $age;

    /**
     * @var string $location
     */
    private $location;

    /**
     * @var datetime $last_connection
     */
    private $last_connection;


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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set inscription_date
     *
     * @param datetime $inscriptionDate
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscription_date = $inscriptionDate;
    }

    /**
     * Get inscription_date
     *
     * @return datetime 
     */
    public function getInscriptionDate()
    {
        return $this->inscription_date;
    }

    /**
     * Set img
     *
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set age
     *
     * @param integer $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set last_connection
     *
     * @param datetime $lastConnection
     */
    public function setLastConnection($lastConnection)
    {
        $this->last_connection = $lastConnection;
    }

    /**
     * Get last_connection
     *
     * @return datetime 
     */
    public function getLastConnection()
    {
        return $this->last_connection;
    }
}