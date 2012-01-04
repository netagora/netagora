<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends Controller
{
    /**
     * @Route("/Documentation")
     * @Template()
     */
    public function documentationAction()
    {
        $name = 'documentation';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Contribution")
     * @Template()
     */
    public function contributionAction()
    {
        $name = 'contribution';
        return array('name' => $name);
    }
    
    /**
     * @Route("/About")
     * @Template()
     */
    public function aboutAction()
    {
        $name = 'about';
        return array('name' => $name);
    }
}
