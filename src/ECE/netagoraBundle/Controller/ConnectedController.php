<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


class ConnectedController extends Controller
{
    /**
     * @Route("/Home/{name}")
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
        return array('name' => $name);
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
     * @Route("/Feeds")
     * @Template()
     */
    public function feedsAction()
    {
        $name = 'feeds';
        return array('name' => $name);
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
     * @Route("/secured/login_check", name="twitter_login_check")
     * 
     */
    public function loginCheckAction()
    {
        
        /*$request = $this->get('request');
        $twitter = $this->get('fos_twitter.service');
        
        $authURL = $twitter->getLoginUrl($request);

        $accessTokenURL = $twitter->getAccessToken($request);
        echo 'Access Token: <pre>'.print_r($accessTokenURL).'</pre><br />';
        
        echo $twitter->getTwitter()->http_code.'<pre>'.print_r($request->server).'</pre>';
        if($twitter->getTwitter()->http_code==200){
            echo 'redirect';
            return new RedirectResponse($authURL);
        }
        else if($accessTokenURL != NULL && $twitter->getTwitter()->http_code==200){
            return new Response('On a l\'access token à envoyer en post à Twitter via l\'url: https://api.twitter.com/oauth/access_token ');
        }else{
            return new Response('non authentifié: '.$twitter->getTwitter()->http_code.'<bt /> <pre>'.var_dump($request->server).'</pre>');
        }*/
        
        
        //return new Response('authentifié'.$authURL.'  <pre>'.var_dump($request->server).'</pre>');
        //return $this->redirect($this->generateUrl('test', array('twitterID' => $accessTokenURL)), 301);
        
        $request = $this->get('request');
        $twitter = $this->get('fos_twitter.service');
        $authURL = $twitter->getLoginUrl($request);

        $response = new RedirectResponse($authURL);
        var_dump($_GET);
        echo $response->getStatusCode();
        if($response->getStatusCode()==302 && empty($_GET)){
            echo '<br />redirect';
            $response = new RedirectResponse($authURL);
            return $response;

            //return $this->redirect($this->generateUrl('home', array('username' => 'authenticated')), 301);
        }else if( !is_null($_GET) && !is_null($_GET['oauth_verifier']) && !is_null($_GET['oauth_token']) ){
            echo $response->getStatusCode().' authURL: '.$authURL;
            //$response = new RedirectResponse('http://127.0.0.1:8888/netagora/web/app_dev.php/secured/login_check?oauth_token='.$_GET['oauth_token'].'&oauth_verifier='.$_GET['oauth_verifier']);
            $buzz = $this->get('buzz');
            $res = $buzz->get('http://bit.ly/aVUeDG');
            print_r($res->getHeader('Location'));
            die;
            echo '<pre>';
            print_r($response);
            echo '</pre>';
            die;
            return $response;
            /*echo '<pre>';
            print_r($response);
            echo '</pre>';
            $accessTokenURL = $twitter->getAccessToken($request);
            echo '<br />Access Token: <pre>';
            print_r($accessTokenURL);
            echo '</pre><br />';*/
        }

       /* var_dump($response);
        echo $response->getStatusCode();
        die; */

        
    }
    
    /** 
    * @Route("/connectTwitter", name="connect_twitter")
    *
    */
    public function connectTwitterAction()
    {   


    }
}
