<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\Publication;

/** 
 * @Route("/twitter")
 *
 */
class TwitterController extends Controller
{
    /** 
     * @Route("/login", name="twitter_login")
     *
     */
    public function twitterLoginAction(Request $request)
    {
        $twitter = $this->get('fos_twitter.service');

        return $this->redirect($twitter->getLoginUrl($request));
    }

    /** 
     * @Route("/login_check", name="twitter_login_check")
     *
     */
    public function loginCheckAction(Request $request)
    {
        $twitter = $this->get('fos_twitter.service');

        if (!$token = $twitter->getAccessToken($request)) {
            throw new \RuntimeException('Unable to get access token on Twitter');
        }

        $oAuth = $this->get('fos_twitter.api');
        $infos = $oAuth->get('account/verify_credentials');

        $user = $this->get('security.context')->getToken()->getUser();
        $user->setTwitterOAuthToken($token['oauth_token']);
        $user->setTwitterOAuthSecret($token['oauth_token_secret']);
        $user->setTwitterID($infos->id);
        $user->setTwitterUsername($infos->screen_name);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
    }
}