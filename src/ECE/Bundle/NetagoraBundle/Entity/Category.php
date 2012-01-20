<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ECE\Bundle\NetagoraBundle\Entity\Category
 */
class Category
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var integer $isDisplayed
     */
    private $isDisplayed;

    /**
     * @var ArrayCollection $users
     */
    private $users;

    /**
     * @var ArrayCollection $knownLinks
     */
    private $knownLinks;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->knownLinks = new ArrayCollection();
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

    public function getKnownLinks()
    {
        return $this->knownLinks;
    }

    public function setKnownLinks($knownLinks)
    {
        $this->knownLinks = array();
        foreach ($knownLinks as $knownLink) {
            $this->addKnownLink($knownLink);
        }
    }

    public function addKnownLink(KnownLink $knownLink)
    {
        if (!$this->knownLinks->contains($knownLink)) {
            $this->knownLinks->add($knownLink);
        }

        if (!$knownLink->getCategory()) {
            $knownLink->setCategory($this);
        }
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users = array();
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }

    public function addUser(User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        if (!$user->contains($this)) {
            $user->addCategory($this);
        }
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set displayed
     *
     * @param Boolean $isDisplayed
     */
    public function setIsDisplayed($isDisplayed)
    {
        $this->isDisplayed = (Boolean) $isDisplayed;
    }

    /**
     * Get displayed
     *
     * @return Boolean 
     */
    public function getIsDisplayed()
    {
        return $this->isDisplayed;
    }

    public function isDisplayed()
    {
        return $this->isDisplayed;
    }
}