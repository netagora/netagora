<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Publication
{
    const TWITTER = 'twitter';

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var KnownLink $knownLink
     */
    private $knownLink;

    /**
     * @var string $socialNetwork
     */
    private $socialNetwork;

    /**
     * @var string $author
     */
    private $author;
    
    /**
     * @var string $authorPicture
     */
    private $authorPicture;
    
    /**
     * @var string $authorScreenName
     */
    private $authorScreenName;

    /**
     * @var datetime $publishedAt
     */
    private $publishedAt;

    /**
     * @var string $reference
     */
    private $reference;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var string $link_url
     */
    private $linkUrl;

    /**
     * @var Boolean $isFavorite
     */
    private $isFavorite;

    public function __construct()
    {
        $this->isFavorite = false;
    }

    public function getCategory()
    {
        if ($this->knownLink) {
            return $this->knownLink->getCategory();
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
     * Set known_link
     *
     * @param KnownLink $knownLink
     */
    public function setKnownLink(KnownLink $knownLink)
    {
        $this->knownLink = $knownLink;
    }

    /**
     * Get known_link
     *
     * @return KnownLink 
     */
    public function getKnownLink()
    {
        return $this->knownLink;
    }

    /**
     * Set network
     *
     * @param string $network
     */
    public function setSocialNetwork($network)
    {
        $this->socialNetwork = $network;
    }

    /**
     * Get network
     *
     * @return string 
     */
    public function getSocialNetwork()
    {
        return $this->socialNetwork;
    }

    /**
     * Set author
     *
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set authorPicture
     *
     * @param string $authorPicture
     */
    public function setAuthorPicture($authorPicture)
    {
        $this->authorPicture = $authorPicture;
    }

    /**
     * Get authorPicture
     *
     * @return string 
     */
    public function getAuthorPicture()
    {
        return $this->authorPicture;
    }

    /**
     * Set authorScreenName
     *
     * @param string $authorScreenName
     */
    public function setAuthorScreenName($authorScreenName)
    {
        $this->authorScreenName = $authorScreenName;
    }

    /**
     * Get authorScreenName
     *
     * @return string 
     */
    public function getAuthorScreenName()
    {
        return $this->authorScreenName;
    }

    /**
     * Set publishedAt
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt(\DateTime $date)
    {
        $this->publishedAt = $date;
    }

    /**
     * Get publishedAt
     *
     * @return datetime 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set reference
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set link_url
     *
     * @param string $linkUrl
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    }

    /**
     * Get link_url
     *
     * @return string 
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    public function setIsFavorite($favorite)
    {
        $this->isFavorite = (Boolean) $favorite;
    }

    public function getIsFavorite()
    {
        return $this->isFavorite;
    }

    public function isFavorite()
    {
        return $this->isFavorite;
    }

    public function changeFavoriteStatus()
    {
        $this->isFavorite = !$this->isFavorite();
    }
}