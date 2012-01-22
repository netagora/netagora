<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Entity\Publication;

class ConnectedController extends Controller
{
    /**
     * @Route("/Home", name="home")
     * @Template()
     */
    public function homeAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/Publications/Refresh", name="twitter_refresh")
     *
     */
    public function refreshAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ECENetagoraBundle:Publication');
        
        $twitter = $this->get('fos_twitter.api');
        $twitter->setOAuthToken(
            $user->getTwitterOAuthToken(),
            $user->getTwitterOAuthSecret()
        );

        $lastPublication = $repository->getLastPublication($user->getId());

        if ($lastPublication) {
            $timeline = $twitter->get('statuses/home_timeline', array(
                'screen_name' => $user->getTwitterID(),
                'since_id' => $lastPublication->getReference()
            ));
        } else {
            $timeline = $twitter->get('statuses/home_timeline', array(
                'screen_name' => $user->getTwitterID(),
                'count' => 10
            ));
        }

        $loader = new TwitterLoader($user);
        $loader->load($timeline);

        $publications = $loader->getPublications();

        $repository->save($publications);

        /*
        Attach kown link and category to the publications
        
        Find right Category
            Appeler main(Publication $publication)

                 Check the $publication->LinkUrl isn't in DB (KnownLink)
                     if in => attribuber le KnownLink correspondant à la publication
                     Sinon faire la tambouille
        */

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/Profile", name="profile")
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
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getVideoPublications($user->getId())
        ;

        return array('publications' => $publications);
    }

    /**
     * @Route("/Music", name="music")
     * @Template()
     */
    public function musicAction()
    {
        return array();
    }
    
    /**
     * @Route("/Photos", name="photos")
     * @Template()
     */
    public function photoAction()
    {
        return array();
    }
    
    /**
     * @Route("/Locations", name="location")
     * @Template()
     */
    public function locationSitesAction()
    {
        return array();
    }
    
    /**
     * @Route("/Other", name="other")
     * @Template()
     */
    public function otherAction()
    {
        return array();
    }
    
    /**
     * @Route("/Feeds", name="feeds")
     * @Template()
     */
    public function feedsAction()
    {
        return array();
    }
    
    /**
     * @Route("/Favourites", name="favourites")
     * @Template()
     */
    public function favouritesAction()
    {
        return array();
    }
    
    /**
     * @Route("/Search")
     * @Template()
     */
    public function searchAction()
    {
        return array();
    }
    
    /**
     * @Route("/Publication/Favorite", name="favourite_publication")
     * @Template()
     */
    public function favouritePublicationAction(Request $request)
    {
        $id         = $request->request->get('publication_id');
        $em         = $this->getDoctrine()->getEntityManager();
        $user       = $this->get('security.context')->getToken()->getUser();
        $repository = $em->getRepository('ECENetagoraBundle:Publication');

        if (!$id || !$publication = $repository->getOwnerPublication($id, $user->getId())) {
            throw new AccessDeniedException();
        }

        $publication->changeFavoriteStatus();
        $em->persist($publication);
        $em->flush();

        return new Response($publication->getId());
    }
}

