<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/** 
 * @Route("/twitter")
 *
 */
class SecurityController extends Controller
{
    /** 
     * @Route("/login", name="twitter_login")
     *
     */
    public function loginAction(Request $request)
    {
        $twitter = $this->get('fos_twitter.service');

        return $this->redirect($twitter->getLoginUrl($request));
    }

    /** 
     * @Route("/login_check", name="twitter_login_check")
     *
     */
    public function loginCheckAction()
    {
        
    }
}