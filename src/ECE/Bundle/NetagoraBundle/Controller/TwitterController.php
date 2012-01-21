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
     * @Route("/refresh", name="twitter_refresh")
     *
     */
    public function refreshAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $twitter = $this->get('fos_twitter.api');
        $twitter->setOAuthToken(
            $user->getTwitterOAuthToken(),
            $user->getTwitterOAuthSecret()
        );

        $timeline = $twitter->get('statuses/home_timeline', array(
            'screen_name' => $user->getTwitterID(),
            'count' => 10
        ));

        foreach ($timeline as $tweet) {
            $text = $tweet->text;
            if (preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $text, $links)) {
                $publication = new Publication();
                $publication->setUser($user);
                $publication->setSocialNetwork(Publication::TWITTER);
                $publication->setAuthor($tweet->user->name);
                $publication->setPublishedAt(new \DateTime($tweet->created_at));
                $publication->setReference($tweet->id_str);
                $publication->setContent($tweet->text);
                $publication->setLinkUrl($links[0]);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($publication);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('home'));
    }

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