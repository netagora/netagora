<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /** 
     * @Route("/twitter/login", name="twitter_login")
     *
     */
    public function twitterLoginAction(Request $request)
    {
        $twitter = $this->get('fos_twitter.service');

        return $this->redirect($twitter->getLoginUrl($request));
    }

    /** 
     * @Route("/login", name="form_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        return array();
    }

    /** 
     * @Route("/twitter/login_check", name="twitter_login_check")
     * @Route("/login_check", name="form_login_check")
     */
    public function loginCheckAction()
    {
        
    }

    /** @Route("/logout", name="logout") */
    public function logoutAction()
    {
        
    }
}