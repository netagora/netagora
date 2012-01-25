<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Form\UserType;
use ECE\Bundle\NetagoraBundle\Entity\Publication;
use ECE\Bundle\NetagoraBundle\Social\Twitter\TwitterLoader;

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
        $user       = $this->get('security.context')->getToken()->getUser();
        $em         = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ECENetagoraBundle:Publication');

        $twitter = $this->get('ece_netagora.twitter_api');
        $twitter->setScreenName($user->getTwitterID());
        $twitter->setOAuthToken(
            $user->getTwitterOAuthToken(),
            $user->getTwitterOAuthSecret()
        );

        if ($publication = $repository->getLastPublication($user->getId())) {
            $twitter->setSinceId($publication->getReference());
        }

        $loader = new TwitterLoader($user);
        $loader->load($twitter->getHomeTimeline());

        $publications = $loader->getPublications();
        $repository->setBrowser($this->get('buzz'));
        $repository->save($publications);

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/Profile", name="profile")
     * @Template()
     */
    public function profileAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UserType(), $user);
        
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $user->target = $this->container->getParameter('photos_dir');
                $user->encodePlainPassword($factory->getEncoder($user));
                $user->eraseCredentials();

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                $user->file = null;
                
                return $this->redirect($this->generateUrl('profile'));
            }
            $user->file = null;
        }
        return array('form' => $form->createView(), 'user' => $user);
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
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getMusicPublications($user->getId())
        ;

        return array('publications' => $publications);
    }
    
    /**
     * @Route("/Photos", name="photos")
     * @Template()
     */
    public function photoAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getPhotoPublications($user->getId())
        ;

        return array('publications' => $publications);
    }
    
    /**
     * @Route("/Locations", name="location")
     * @Template()
     */
    public function locationSitesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getLocationPublications($user->getId())
        ;

        return array('publications' => $publications);
    }
    
    /**
     * @Route("/Other", name="other")
     * @Template()
     */
    public function otherAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getOtherPublications($user->getId())
        ;

        return array('publications' => $publications);
    }
    
    /**
     * @Route("/Feeds", name="feeds")
     * @Template()
     */
    public function feedsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getAllPublications($user->getId())
        ;

        return array('publications' => $publications);
    }
    
    /**
     * @Route("/Favourites", name="favourites")
     * @Template()
     */
    public function favouritesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $publications = $em
            ->getRepository('ECENetagoraBundle:Publication')
            ->getFavoritesPublications($user->getId())
        ;

        return array('publications' => $publications);
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
    
    /**
     * @Route("/Aggbox", name="aggbox")
     * @Template()
     */
    public function aggboxAction(Request $request)
    {
        return array();
    }
}

