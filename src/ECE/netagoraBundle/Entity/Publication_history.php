<?php

namespace ECE\netagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECE\netagoraBundle\Entity\Publication_history
 */
class Publication_history
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $publication
     */
    private $publication;

    /**
     * @var string $old_cat
     */
    private $old_cat;

    /**
     * @var string $current_cat
     */
    private $current_cat;

    /**
     * @var datetime $change_date
     */
    private $change_date;


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
     * Set publication
     *
     * @param string $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * Get publication
     *
     * @return string 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set old_cat
     *
     * @param string $oldCat
     */
    public function setOldCat($oldCat)
    {
        $this->old_cat = $oldCat;
    }

    /**
     * Get old_cat
     *
     * @return string 
     */
    public function getOldCat()
    {
        return $this->old_cat;
    }

    /**
     * Set current_cat
     *
     * @param string $currentCat
     */
    public function setCurrentCat($currentCat)
    {
        $this->current_cat = $currentCat;
    }

    /**
     * Get current_cat
     *
     * @return string 
     */
    public function getCurrentCat()
    {
        return $this->current_cat;
    }

    /**
     * Set change_date
     *
     * @param datetime $changeDate
     */
    public function setChangeDate($changeDate)
    {
        $this->change_date = $changeDate;
    }

    /**
     * Get change_date
     *
     * @return datetime 
     */
    public function getChangeDate()
    {
        return $this->change_date;
    }
}