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
                
                return $this->redirect($this->generateUrl('Profile'));
            }
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
     * @Route("/favouritePublication", name="favouritePublication")
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

