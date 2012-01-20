<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Form\UserType;

class DisconnectedController extends Controller
{
    /**
     * @Route("/Subscribe", name="subscribe")
     * @Template()
     */
    public function subscribeAction(Request $request)
    {
        $user  = new User();
        $form = $this->createForm(new UserType(), $user);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $user->encodePassword($factory->getEncoder($user));
                $user->target = $this->container->getParameter('photos_dir');

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('home'));
            }
        }

        return array(
            'user' => $user,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/menu_notlogged", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
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
