<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/AdminPanel/StatsUser")
     * @Template()
     */
    public function statsUserAction()
    {
        $name = 'statUser';
        return array('name' => $name);
    }
    
    /**
     * @Route("/AdminPanel/StatsSite")
     * @Template()
     */
    public function statsSiteAction()
    {
        $name = 'statSite';
        return array('name' => $name);
    }
}
