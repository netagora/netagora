<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ECE\Bundle\NetagoraBundle\Entity\User
 *
 * @UniqueEntity(fields={"username"}, message="This username is already used.")
 * @UniqueEntity(fields={"email"}, message="This email is already used.")
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $username
     * @Assert\NotBlank()
     * @Assert\MinLength(6)
     * @Assert\MaxLength(15)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9]+$/", message="The username can only contains alphabetical and numeric characters.")
     */
    private $username;

    /**
     * @var string $salt
     */
    private $salt;

    /**
     * @var string $password
     *
     */
    private $password;

    /**
     * @var string $password
     * @Assert\NotBlank()
     * @Assert\MinLength(8)
     */
    private $plainPassword;

    /**
     * @var string $email
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string $firstName
     * @Assert\NotBlank()
     * @Assert\MinLength(2)
     */
    private $firstName;
    
    /**
     * @var string $lastName
     * @Assert\NotBlank()
     * @Assert\MinLength(2)
     */
    private $lastName;

    /**
     * @var string $picture
     */
    private $picture;

    /**
     * @var string $location
     */
    private $location;

    /**
     * @var datetime $birthdate
     * @Assert\Date()
     */
    private $birthdate;
    
    /**
     * @var datetime $registeredAt
     */
    private $registeredAt;

    /** 
     * @var string
     */
    private $twitterID;

    /** 
     * @var string
     */
    private $twitterUsername;

    /** 
     * @var string
     */
    private $twitterOAuthToken;

    /** 
     * @var string
     */
    private $twitterOAuthSecret;

    /** 
     * @var array
     */
    private $roles;

    /** 
     * @var Boolean
     */
    private $isEnabled;

    /** 
     * @var ArrayCollection
     */
    private $categories;

    /** 
     * @var ArrayCollection
     */
    private $publications;
    
    /** 
     * @var ArrayCollection
     */
    private $aggbox;

    /** 
     * @var ArrayCollection
     */
    private $tokens;

    /**
     * @var UploadedFile $file
     * @Assert\Image(maxSize="1M")
     */
    public $file;

    public $target;

    public function __construct()
    {
        $this->isEnabled = true;
        $this->roles = 'ROLE_USER';
        $this->registeredAt = new \DateTime();
        $this->salt = $this->generateRandomSalt();
        $this->categories = new ArrayCollection();
        $this->publications = new ArrayCollection();
        $this->tokens = new ArrayCollection();
    }

    private function generateRandomSalt()
    {
        return md5(uniqid().'*'.time().'|'.rand(0, 999999));
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    public function encodePlainPassword(PasswordEncoderInterface $encoder)
    {
        $this->salt = $this->generateRandomSalt();

        $password = $encoder->encodePassword($this->plainPassword, $this->salt);

        $this->setPassword($password);
    }

    public function preUpload()
    {
        if ($this->file instanceOf UploadedFile) {
            $this->picture = $this->username.'.'.$this->file->guessExtension();
        }
    }

    public function upload()
    {
        if ($this->file instanceOf UploadedFile) {
            $this->file->move($this->target, $this->picture);
            $this->file = null;
        }
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function getTwitterToken()
    {
        return $this->getTokenByType('twitter');
    }

    public function getFacebookToken()
    {
        return $this->getTokenByType('facebook');
    }

    private function getTokenByType($type)
    {
        foreach ($this->tokens as $token) {
            if ($type === $token->getType()) {
                return $token;
            }
        }
    }

    public function setTokens($tokens)
    {
        $this->tokens = array();
        foreach ($tokens as $token) {
            $this->addToken($token);
        }
    }

    public function addToken(ServiceToken $token)
    {
        if (!$this->tokens->contains($token)) {
            $this->token->add($token);
        }

        if (!$token->getUser()) {
            $token->setUser($this);
        }
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = array();
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        if (!$category->contains($this)) {
            $category->addUser($this);
        }
    }

    public function getPublications()
    {
        return $this->publications;
    }

    public function getFavoritePublications()
    {
        $favorites = array();
        foreach ($this->publications as $publication) {
            if ($publication->isFavorite()) {
                $favorites[] = $publication;
            }
        }

        return $favorites;
    }

    public function setPublications($publications)
    {
        $this->publications = array();
        foreach ($publications as $publication) {
            $this->addPublication($publication);
        }
    }

    public function addPublication(Publication $publication)
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
        }

        if (!$publication->getUser()) {
            $publication->setUser($this);
        }
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setIsEnabled($enabled)
    {
        $this->isEnabled = (Boolean) $enabled;
    }

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        //return array($this->roles);
        return array('ROLE_USER', 'ROLE_MEMBER');
    }

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
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Set lastname
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
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
     * @param DateTime $date
     */
    public function setRegisteredAt(\DateTime $date)
    {
        $this->registeredAt = $date;
    }

    /**
     * Get inscriptionDate
     *
     * @return DateTime 
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }
    
    /**
     * Set twitterID
     *
     * @param string $twitterID
     */
    public function setTwitterID($twitterID)
    {
        $this->twitterID = $twitterID;
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
        $this->twitterUsername = $twitterUsername;
    }

    /**
     * Get twitter_username
     *
     * @return string 
     */
    public function getTwitterUsername()
    {
        return $this->twitterUsername;
    }

    public function setTwitterOAuthToken($token)
    {
        $this->twitterOAuthToken = $token;
    }

    public function getTwitterOAuthToken()
    {
        return $this->twitterOAuthToken;
    }

    public function setTwitterOAuthSecret($secret)
    {
        $this->twitterOAuthSecret = $secret;
    }

    public function getTwitterOAuthSecret()
    {
        return $this->twitterOAuthSecret;
    }
}