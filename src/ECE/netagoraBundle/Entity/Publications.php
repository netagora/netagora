<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Publications
 */
class Publications
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
     * @var string $known_link
     */
    private $known_link;

    /**
     * @var integer $network
     */
    private $network;

    /**
     * @var string $author
     */
    private $author;

    /**
     * @var datetime $date_published
     */
    private $date_published;

    /**
     * @var string $publication_ref
     */
    private $publication_ref;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var string $link_url
     */
    private $link_url;


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
     * Set known_link
     *
     * @param string $knownLink
     */
    public function setKnownLink($knownLink)
    {
        $this->known_link = $knownLink;
    }

    /**
     * Get known_link
     *
     * @return string 
     */
    public function getKnownLink()
    {
        return $this->known_link;
    }

    /**
     * Set network
     *
     * @param integer $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * Get network
     *
     * @return integer 
     */
    public function getNetwork()
    {
        return $this->network;
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
     * Set date_published
     *
     * @param datetime $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->date_published = $datePublished;
    }

    /**
     * Get date_published
     *
     * @return datetime 
     */
    public function getDatePublished()
    {
        return $this->date_published;
    }

    /**
     * Set publication_ref
     *
     * @param string $publicationRef
     */
    public function setPublicationRef($publicationRef)
    {
        $this->publication_ref = $publicationRef;
    }

    /**
     * Get publication_ref
     *
     * @return string 
     */
    public function getPublicationRef()
    {
        return $this->publication_ref;
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
        $this->link_url = $linkUrl;
    }

    /**
     * Get link_url
     *
     * @return string 
     */
    public function getLinkUrl()
    {
        return $this->link_url;
    }
}