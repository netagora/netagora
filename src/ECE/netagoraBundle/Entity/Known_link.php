<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Known_link
 */
class Known_link
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $category
     */
    private $category;

    /**
     * @var string $title_head
     */
    private $title_head;

    /**
     * @var string $h1
     */
    private $h1;

    /**
     * @var string $h2
     */
    private $h2;

    /**
     * @var string $tags
     */
    private $tags;

    /**
     * @var string $main_url
     */
    private $main_url;

    /**
     * @var string $keywords
     */
    private $keywords;


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
     * Set category
     *
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title_head
     *
     * @param string $titleHead
     */
    public function setTitleHead($titleHead)
    {
        $this->title_head = $titleHead;
    }

    /**
     * Get title_head
     *
     * @return string 
     */
    public function getTitleHead()
    {
        return $this->title_head;
    }

    /**
     * Set h1
     *
     * @param string $h1
     */
    public function setH1($h1)
    {
        $this->h1 = $h1;
    }

    /**
     * Get h1
     *
     * @return string 
     */
    public function getH1()
    {
        return $this->h1;
    }

    /**
     * Set h2
     *
     * @param string $h2
     */
    public function setH2($h2)
    {
        $this->h2 = $h2;
    }

    /**
     * Get h2
     *
     * @return string 
     */
    public function getH2()
    {
        return $this->h2;
    }

    /**
     * Set tags
     *
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set main_url
     *
     * @param string $mainUrl
     */
    public function setMainUrl($mainUrl)
    {
        $this->main_url = $mainUrl;
    }

    /**
     * Get main_url
     *
     * @return string 
     */
    public function getMainUrl()
    {
        return $this->main_url;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}