<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /** 
     * @Route("/login", name="form_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        return array();
    }

    /** 
     * @Route("/login_check", name="form_login_check")
     *
     */
    public function loginCheckAction()
    {
        
    }

    /** @Route("/logout", name="logout") */
    public function logoutAction()
    {
        
    }
}