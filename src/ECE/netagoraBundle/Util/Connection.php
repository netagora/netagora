<?php

/**
*  Class Connection
*/
namespace ECE\netagoraBundle\Util;
class Connection{

    private $host;
    private $port;
    private $db_name;
    private $user;
    private $password;
    private $connection;
    
    public function __construct( $host, $port, $db_name, $user, $password ){
        
        $this->host = $host; // le chemin vers le serveur
        $this->port = $port;
        $this->db_name = $db_name; // le nom de votre base de données
        $this->user = $user; // nom d'utilisateur pour se connecter
        $this->password = $password; // mot de passe de l'utilisateur pour se connecter        
    }
    
    public function setConnection($connection){
        $this->connection = $connection;
    }
	public function getConnection(){
		return $this->connection;
	}
    
    public function connect(){
        try
        {
            $connexion = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db_name, $this->user, $this->password);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->setConnection($connexion);
        }
        catch(Exception $e)
        {
            echo 'Erreur : '.$e->getMessage().'<br />';
            echo 'N° : '.$e->getCode();
        }
        
    }
    
    //Return only one object
    public function fetchSingle($query, $params = array()){
        
        $prepare_stmt= $this->connection->prepare($query); 
        $prepare_stmt->execute($params);
        return $prepare_stmt->fetch(PDO::FETCH_OBJ);
    }
    
    //Return a set of objects
    public function fetchAll($query, $params = array()){
        
        $prepare_stmt= $this->connection->prepare($query); 
        $prepare_stmt->execute($params);
        return $prepare_stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
}