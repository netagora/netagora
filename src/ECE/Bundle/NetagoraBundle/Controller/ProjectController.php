<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends Controller
{
    /**
     * @Route("/Documentation", name="documentation")
     * @Template()
     */
    public function documentationAction()
    {
        return array();
    }
    
    /**
     * @Route("/Contribution", name= "contribution")
     * @Template()
     */
    public function contributionAction()
    {
        return array();
    }
    
    /**
     * @Route("/About", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Route("/Credits", name="credits")
     * @Template()
     */
    public function creditsAction()
    {
        return array();
    }
    
    /**
     * @Route("/Badges", name="badges")
     * @Template()
     */
    public function badgesAction()
    {
        return array();
    }
}
