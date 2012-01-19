<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;

class ConnectedController extends Controller
{
    /**
     * @Route("/Home/{name}", name="home")
     * @Template()
     */
    public function homeAction($name)
    {
        $session = $this->getRequest()->getSession();
        $user_id = $session->get('user_id');
        
        if (isset($user_id) && $user_id != NULL){
            $current_user = $session->get('user_id');
            return array('name' => $name, 'current_user' => $current_user);
        }else{
            return array('name' => 'anonymous', 'current_user' => '0');
        }
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
        $user = new User();
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        $feed_author = 'me';
        $feed_author_url = 'http://facebook.com';
        $display = 'display';
        $link_url ='http://www.youtube.com/embed/Vv5LEuJJ-f0?rel=0';
        $link = 'mylink';
        $feed_text = 'content';
         $avatar_url = 'https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png';
               
        return array('name' => $name, 
                     'feed_author' => $feed_author, 
                     'feed_author_url' => $feed_author_url, 
                     'display' => $display, 
                     'link_url' => $link_url, 
                     'link' => $link, 
                     'feed_text' => $feed_text, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons, 
                     'avatar_url' => $avatar_url);
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
     * @Route("/Feeds", name="Feeds")
     * @Template()
     */
    public function feedsAction()
    {
        return array();
    }
    
    /**
     * @Route("/Feeds", name="refresh")
     * @Template()
     */
    public function refreshAction()
    {

        return array();
        /*$this->render('ECENetagoraBundle:Connected:feeds.html.twig', array(
                        'form' => $form->createView(),
                        ));*/
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
    
    /**
     * @Route("/foo/login_check", name="foo_login_check")
     * 
     */
    public function loginCheckAction()
    {
        
    }
    
    /** 
    * @Route("/connectTwitter", name="connect_twitter")
    *
    */
    public function connectTwitterAction()
    {   
        
        $request = $this->get('request');
        $twitter = $this->get('fos_twitter.service');

        $authURL = $twitter->getLoginUrl($request);
        $response = new RedirectResponse($authURL);

        return $response;

    }
}
