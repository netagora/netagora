<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

/**
 * ECE\Bundle\NetagoraBundle\Entity\KnownLink
 */
class KnownLink
{
    private $id;

    /**
     * @var Category $category
     */
    private $category;

    /**
     * @var string $title
     */
    private $title;

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
    private $url;

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
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param string|array $tags
     */
    public function setTags($tags)
    {
        if (is_array($tags)) {
            $tags = implode(', ', $tags);
        }

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

    public function getTagsList()
    {
        return array_unique(explode(', ', $this->tags));
    }

    /**
     * Set main_url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        if (is_array($keywords)) {
            $keywords = implode(', ', $keywords);
        }

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

    public function getKeywordsList()
    {
        return array_unique(explode(', ', $this->keywords));
    }
}