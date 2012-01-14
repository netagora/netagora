<?php

namespace ECE\netagoraBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ECE\netagoraBundle\Entity\User
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $username
     */
     //protected $username;

    /**
     * @var string $password
     */
     //protected $password;

    /**
     * @var string $email
     */
    protected $email;

    /**
     * @var string $picture
     */
    private $picture;
    
    /**
     * @var string $location
     */
    private $location;
    
    /**
     * @var string $firstname
     */
    private $firstname;
    
    /**
     * @var string $lastname
     */
    private $lastname;
    
    /**
     * @var datetime $birthdate
     */
    private $birthdate;
    
    /**
     * @var datetime $inscriptionDate
     */
    private $inscriptionDate;

    /**
     * @var datetime $lastConnection
     */
    private $lastConnection;
    
    /** 
     * @var string
     */
    protected $twitterID;

    /** 
     * @var string
     */
    protected $twitter_username;
    
    /**
     * @Assert\Image(maxSize="1M")
     */
    public $file;

    function __construct()
    {
        parent::__construct();
        $this->lastConnection = new \DateTime();
        $this->inscriptionDate = new \DateTime();
    }

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
   /* public function setUsername($username)
    {
        $this->username = $username;
    }*/

    /**
     * Get username
     *
     * @return string 
     */
    /*  public function getUsername()
    {
        return $this->username;
    }*/

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

    /**
     * Set password
     *
     * @param string $password
     */
    /*public function setPassword($password)
    {
        $this->password = $password;
    }*/

    /**
     * Get password
     *
     * @return string 
     */
    /*public function getPassword()
    {
        return $this->password;
    }*/
    
    /**
     * Set picture
     *
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
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
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * Set birthdate
     *
     * @param integer $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * Get birthdate
     *
     * @return integer 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set inscriptionDate
     *
     * @param datetime $inscriptionDate
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;
    }

    /**
     * Get inscriptionDate
     *
     * @return datetime 
     */
    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    /**
     * Set lastConnection
     *
     * @param datetime $lastConnection
     */
    public function setLastConnection($lastConnection)
    {
        $this->lastConnection = $lastConnection;
    }

    /**
     * Get lastConnection
     *
     * @return datetime 
     */
    public function getLastConnection()
    {
        return $this->lastConnection;
    }
    
    /**
     * Set twitterID
     *
     * @param string $twitterID
     */
    public function setTwitterID($twitterID)
    {
        $this->twitterID = $twitterID;
        $this->setTwitterUsername($twitterID);
        $this->salt = '';
    }

    /**
     * Get twitterID
     *
     * @return string 
     */
    public function getTwitterID()
    {
        return $this->twitterID;
    }

    /**
     * Set twitter_username
     *
     * @param string $twitterUsername
     */
    public function setTwitterUsername($twitterUsername)
    {
        $this->twitter_username = $twitterUsername;
    }

    /**
     * Get twitter_username
     *
     * @return string 
     */
    public function getTwitterUsername()
    {
        return $this->twitter_username;
    }

    public function getAbsolutePath()
    {
        return null === $this->picture ? null : $this->getUploadRootDir().'/'.$this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir().'/'.$this->picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->picture = $this->file->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}