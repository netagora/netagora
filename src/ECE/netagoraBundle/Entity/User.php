<?php

namespace ECE\netagoraBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    protected $password;
    private $login;
    private $mail;
    private $inscription;
    private $image;
    private $age;
    private $location;
    private $lastConnection;
    //private static $conn;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}







/*
class User{
    protected $id;
    private $password;
    private $login;
    private $mail;
    private $inscription;
    private $image;
    private $age;
    private $location;
    private $lastConnection;
    //private static $conn;
    
    function __construct(){
    
    	// INIT ID WITH SESSION!
    	
    }*/
    
    /**
    * @name get_user_infos
    * @param id
    * @description retrieve infos about the logged user
    **/
   /* function get_user_infos($id){
    	
    	$user_query = "SELECT * FROM user WHERE id = $id";
    	$request = mysql_query($user_query);
    	
    	while($object = mysql_fetch_array($request)){
    	
    		$login = $object["login"];
    		$password = $object["password"];
    		$mail = $object["mail"];
    		$inscription = $object["inscription_date"];
    	
    	}
    	
    	$user_infos_query = "SELECT * FROM info_user WHERE user_id = $id";
    	$request = mysql_query($user_query);
    	
    	while($object = mysql_fetch_array($request)){
    	
    		$image = $object["image"];
    		$age = $object["age"];
    		$location = $object["location"];
    		$lastConnection = $object["last_connection"];
    	
    	}
    	
    
    }
    
}*/