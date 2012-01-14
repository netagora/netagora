<?php

namespace ECE\netagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\netagoraBundle\Entity\User;
use ECE\netagoraBundle\Entity\Document;
use ECE\netagoraBundle\Form\UserType;
use Sensio\Bundle\BuzzBundle\DependencyInjection\SensioBuzzExtension;

class DisconnectedController extends Controller
{
    /**
     * @Route("/Subscribe")
     * @Template()
     */
    public function subscribeAction()
    {
        /* Crawl de la page
        $browser = new Buzz\Browser();
        $response = $browser->get('http://bit.ly/aVUeDG');
        //echo $browser->getJournal()->getLastRequest()."\n";
        print_r($response->getHeader('Location'));
        */
        
        $session = $this->getRequest()->getSession ();
        $entity  = new User();
        $request = $this->getRequest();
        $form    = $this->createForm(new UserType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setPassword(md5($entity->getPassword()));//Encode password in md5
            $entity->setLastLogin(new \DateTime());
            
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();
            //set session
            $session -> set ( 'user_id' , $entity->getId() );

            return $this->redirect($this->generateUrl('home', array('username' => $entity->getUsername())), 301);//permanent redirection
            //return new Response ( 'response' );
            
        }

        return $this->render('netagoraBundle:Disconnected:subscribe.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    
    /**
     * @Route("/Login")
     * @Template()
     */
    public function loginAction()
    {
        $name = 'login';
        return array('name' => $name);
    }
    
    /**
     * @Route("/PasswordRetrieval")
     * @Template()
     */
    public function passwordRetrievalAction()
    {
        $name = 'ForgotPassword';
        return array('name' => $name);
    }
}
