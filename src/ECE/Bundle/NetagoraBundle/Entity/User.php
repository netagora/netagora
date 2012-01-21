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
     * @Assert\NotBlank()
     * @Assert\MinLength(8)
     */
    private $password;

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
    private $tokens;

    /**
     * @var UploadedFile $file
     * @Assert\Image(maxSize="156k")
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
        
    }

    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    public function encodePassword(PasswordEncoderInterface $encoder)
    {
        $this->salt = $this->generateRandomSalt();

        $password = $encoder->encodePassword($this->password, $this->salt);

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
            $this->file->move($this->target, $this->path);
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
        //$this->setTwitterUsername($twitterID);
        //$this->salt = '';
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

    /*
    static public function hydrateObject($userDB){
        $user = new User();
        $user->setUsername($userDB[0]['username']);
        $user->setEmail($userDB[0]['email']);
        $user->setPicture($userDB[0]['picture']);
        $user->setLocation($userDB[0]['location']);
        $user->setFirstName($userDB[0]['firstName']);
        $user->setLastName($userDB[0]['lastName']);
        $user->setBirthdate($userDB[0]['birthdate']);
        $d = new \DateTime($userDB[0]['registeredAt'], new \DateTimeZone("Europe/Paris"));
        $user->setRegisteredAt($d);
        $user->setTwitterID($userDB[0]['twitterID']);
        return $user;
    }
    */

    public function getSocialButtons($network, $tweet_id)
    {
        if($network == "f"){
            // for the social buttons at the bottom of the feed display
            $social_buttons='<div class="fb-like" data-href="http://blop.ca" data-send="true" data-layout="button_count" data-width="200" data-show-faces="true"></div>';
        }
        else if($network == "t"){
            $t_reply = '<a class="t_reply" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet_id.'"> </a>';
            $t_fav = '<a class="t_favorite" href="https://twitter.com/intent/retweet?tweet_id='.$tweet_id.'"> </a>';
            $t_retweet = '<a class="t_retweet" href="https://twitter.com/intent/favorite?tweet_id='.$tweet_id.'"> </a>';
            $social_buttons = $t_reply . ' ' . $t_fav . ' ' . $t_retweet;
        }

        return $social_buttons;
    }
}