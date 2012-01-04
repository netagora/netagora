<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DisconnectedController extends Controller
{
    /**
     * @Route("/Subscribe")
     * @Template()
     */
    public function subscribeAction()
    {
        $name = 'subscribe';
        return array('name' => $name);
    }
    
    /**
     * @Route("/Login")
     * @Template()
     */
    public function loginAction()
    {
        $name = 'login';
        return array('name' => $name);
    }
    
    /**
     * @Route("/PasswordRetrieval")
     * @Template()
     */
    public function passwordRetrievalAction()
    {
        $name = 'ForgotPassword';
        return array('name' => $name);
    }
}
