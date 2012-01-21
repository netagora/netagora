<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        if ($this->get('security.context')->isGranted('ROLE_MEMBER')) {
            return $this->redirect($this->generateUrl('home'));
        }

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

                // Send the confirmation email
                $this->sendConfirmationEmail($user);

                // Authenticate the newly created user.
                $this->authenticateUserToken($user);

                return $this->redirect($this->generateUrl('home'));
            }
        }

        return array(
            'user' => $user,
            'form' => $form->createView(),
        );
    }

    private function authenticateUserToken(User $user)
    {
        $token = new UsernamePasswordToken($user->getUsername(), $user->getPassword(), 'public', $user->getRoles());
        $token->setUser($user);
        $this->get('security.context')->setToken($token);
    }

    private function sendConfirmationEmail(User $user)
    {
        $robotName  = $this->container->getParameter('robot_name');
        $robotEmail = $this->container->getParameter('robot_email');

        $body = $this->renderView(
            'ECENetagoraBundle:Notification:registration.txt.twig',
            array('user' => $user)
        );

        $message = \Swift_Message::getInstance()
            ->setFrom(array($robotEmail => $robotName))
            ->setTo(array($user->getEmail() => $user->getFullName()))
            ->setSubject('Welcome to the Netagora Social Platform')
            ->setBody($body)
        ;

        $this->get('mailer')->send($message);
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
