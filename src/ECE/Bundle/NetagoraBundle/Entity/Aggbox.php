<?php

namespace ECE\Bundle\NetagoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Aggbox
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var User $user
     */
    private $user;
    
    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $content
     */
    private $content;
    
    /**
     * @var datetime $submitDate
     */
    private $submitDate;
}