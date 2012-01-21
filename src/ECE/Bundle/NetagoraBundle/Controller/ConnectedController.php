<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;

class ConnectedController extends Controller
{
    /**
     * @Route("/Home", name="home")
     * @Template()
     */
    public function homeAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('ece_username')) {
            $session->set('ece_username', $this->get('security.context')->getToken()->getUsername());
        }

        return array();
    }

    /**
     * @Route("/Profile")
     * @Template()
     */
    public function profileAction()
    {
        $name = 'profile';
        $user = new User();
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $mail_address = 'bla@gmail.com';
        $name = 'first last';
        $location = 'paris';
        $avatar_url = 'https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png';
               
        return array('name' => $name, 
                     'mail_address' => $mail_address, 
                     'name' => $name, 
                     'location' => $location, 
                     'avatar_url' => $avatar_url);
    }
    
    /**
     * @Route("/Videos", name="videos")
     * @Template()
     */
    public function videoAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 1 => publication->known_link.category_id
        $publications = $em->getRepository('ECENetagoraBundle:Publication')
                           ->findAllPublicationsByCategory('video');
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
    }
    
    /**
     * @Route("/Music", name="music")
     * @Template()
     */
    public function musicAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 2 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
    }
    
    /**
     * @Route("/Photos", name="photos")
     * @Template()
     */
    public function photoAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 3 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
    }
    
    /**
     * @Route("/Locations", name="location")
     * @Template()
     */
    public function locationSitesAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 4 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
    }
    
    /**
     * @Route("/Other", name="other")
     * @Template()
     */
    public function otherAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 4 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
    }
    
    /**
     * @Route("/Feeds", name="feeds")
     * @Template()
     */
    public function feedsAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 4 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
        
    }
    
    /**
     * @Route("/Favourites", name="favourites")
     * @Template()
     */
    public function favouritesAction()
    {
        $publications = '';
        //Get the user connected
        $user = new User();
        $user->setTwitterUsername('Saro0h');
        $user->setPicture('https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png');
        
        $network = "t";
        $social_buttons = $user->getSocialButtons($network,'158903826945024000');
        $networking = 'twitter';
        
        //Get all publications
        $em = $this->getDoctrine()->getEntityManager();
        //Récupérer les publications category.id = 4 => publication->known_link.category_id
        $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
        $publications = $query->getResult();
          
        //?
        $display = 'display';
               
        return array('publications' => $publications,
                     'user' => $user,
                     'display' => $display, 
                     'networking' => $networking, 
                     'social_buttons' => $social_buttons
                     );
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
     * @Route("/Search")
     * @Template()
     */
    public function searchAction()
    {
        $name = 'search';
             $user = new User();
             $network = "t";
             $social_buttons = $user->getSocialButtons($network,'158903826945024000');
             $networking = 'twitter';
             $feed_author = 'me';
             $feed_author_url = 'http://facebook.com';
             $display = 'display';
             $link_url ='http://bla.ca';
             $link = 'mylink';
             $feed_text = 'content';
             $category = 'video';
              $avatar_url = 'https://si0.twimg.com/profile_images/1547581423/moy_reasonably_small.png';
                    
             return array('name' => $name, 'feed_author' => $feed_author, 'feed_author_url' => $feed_author_url, 'display' => $display, 'link_url' => $link_url, 'link' => $link, 'feed_text' => $feed_text, 'networking' => $networking, 'social_buttons' => $social_buttons, 'avatar_url' => $avatar_url);
        
    }
}
