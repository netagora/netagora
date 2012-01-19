<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\BuzzBundle\DependencyInjection\SensioBuzzExtension;
use ECE\Bundle\NetagoraBundle\Security\User\Provider\TwitterUserProvider;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Form\UserType;
use ECE\Bundle\NetagoraBundle\Entity\Publication;

class DisconnectedController extends Controller
{
    /**
     * @Route("/Subscribe", name="subscribe")
     * @Template()
     */
    public function subscribeAction()
    {
        $debug = 'SubscribeAction';
        $em = $this->getDoctrine()->getEntityManager();

        $request = $this->getRequest();
        
        /* Subscribe form */
        $error = '';
        $entity  = new User();
        $entity->setUsername('Enter your username');
        
        $form = $this->createForm(new UserType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid() && $error != '') {
            $entity->setLastLogin(new \DateTime());
            $entity->upload();
            //Update the user $this->manager->updateUser($user);
            $em->persist($entity);
            $em->flush();
            //set session
            $session->set('user_id', $entity->getId());
           // return $this->redirect($this->generateUrl('home', array('username' => $entity->getUsername()), 301);//permanent redirection
        }
        
        return $this->render('ECENetagoraBundle:Disconnected:subscribe.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            //'debug'  => $debug,
            //'error'  => $error,
        ));
    }
    
    /**
     * @Route("/Login")
     * @Template()
     */
    public function loginAction()
    {
        return array();
    }
    
    /**
     * @Route("/PasswordRetrieval", name="forgot")
     * @Template()
     */
    public function passwordRetrievalAction(Request $request)
    {
        $error = '';
        $debug = '';

        $email = $request->request->get('mail');
        
        //Find the user
        $em = $this->getDoctrine()->getEntityManager();
        if ($email) {
            $user = $em->getRepository('ECENetagoraBundle:User')->findOneByEmail($email);
        }
        
        if (!empty($user)) {
            $message = \Swift_Message::newInstance()
                    ->setSubject('Your access to netagora.net')
                    ->setFrom(array('no-reply@netagora.net'=>'Netagora Team'))
                    ->setTo($email)
                    ->setBody('Hi '.$user->getFirstName().'!

                    Your username is '.$user->getUsername().'
                    Your password is '.$user->getPassword().'

                    See you soon on www.netagora.net !

                    The netagora team.
                    ');
            $this->get('mailer')->send($message);
        } else if ($request->request->get('mail') != ''){
            $error = 'Your account doesn\'t exist';
        }
        
        return array('error'=>$error, 'debug' => $debug);
    }
}
