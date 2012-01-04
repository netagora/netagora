<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ConnectedController extends Controller
{
    /**
     * @Route("/Home/{name}")
     * @Template()
     */
    public function homeAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * @Route("/Profile")
     * @Template()
     */
    public function profileAction()
    {
        $name = 'profile';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Videos")
     * @Template()
     */
    public function videoAction()
    {
        $name = 'video';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Music")
     * @Template()
     */
    public function musicAction()
    {
        $name = 'music';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Photos")
     * @Template()
     */
    public function photoAction()
    {
        $name = 'photo';
        return array('name' => $name);
    }
    
    /**
     * @Route("/InfoSites")
     * @Template()
     */
    public function infoSitesAction()
    {
        $name = 'infoSites';
        return array('name' => $name);
    }
    
    /**
     * @Route("/EduSites")
     * @Template()
     */
    public function eduSitesAction()
    {
        $name = 'eduSites';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Locations")
     * @Template()
     */
    public function locationSitesAction()
    {
        $name = 'location';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Other")
     * @Template()
     */
    public function otherAction()
    {
        $name = 'other';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Feeds")
     * @Template()
     */
    public function feedsAction()
    {
        $name = 'feeds';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Favourites")
     * @Template()
     */
    public function favouritesAction()
    {
        $name = 'favourites';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Search")
     * @Template()
     */
    public function searchAction()
    {
        $name = 'search';
        return array('name' => $name);
    }
}
