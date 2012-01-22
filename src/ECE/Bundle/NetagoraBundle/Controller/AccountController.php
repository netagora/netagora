<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Entity\PasswordRequest;
use ECE\Bundle\NetagoraBundle\Entity\ResetPassword;
use ECE\Bundle\NetagoraBundle\Form\UserType;
use ECE\Bundle\NetagoraBundle\Form\PasswordRequestType;
use ECE\Bundle\NetagoraBundle\Form\ResetPasswordType;

class AccountController extends Controller
{
    /**
     * This action handles the registration form.
     *
     * @param Request $request The Request object
     * @return array|RedirectResponse The redirection or template variables
     *
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
                $user->target = $this->container->getParameter('photos_dir');
                $user->encodePlainPassword($factory->getEncoder($user));
                $user->eraseCredentials();

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

        return array('form' => $form->createView());
    }

    /**
     * This actions handles the password retrieval.
     *
     * @param Request $request The Request object
     * @return array|RedirectResponse The redirection or template variables
     *
     * @Route("/Account/Password/Retrieve", name="request_password")
     * @Template("ECENetagoraBundle:Account:password.html.twig")
     */
    public function requestPasswordAction(Request $request)
    {
        $token = new PasswordRequest();
        $form = $this->createForm(new PasswordRequestType(), $token);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('ECENetagoraBundle:User');
                if ($repository->isPasswordRequestValid($token)) {
                    $em->persist($token);
                    $em->flush();
                    $this->sendPasswordRequestEmail($token);

                    return $this->redirect($this->generateUrl('request_password_confirmation'));
                }
            }
        }
        
        return array('form' => $form->createView());
    }

    /**
     * This actions handles the password retrieval confirmation.
     *
     * @param void
     * @return array The template variables
     *
     * @Route("/Account/Password/Confirmation", name="request_password_confirmation")
     * @Template("ECENetagoraBundle:Account:passwordConfirmation.html.twig")
     */
    public function requestPasswordConfirmationAction()
    {
        return array();
    }

    /**
     * This actions confirms the user his password has been changed.
     *
     * @Route("/Account/Password/Reset", name="password_changed")
     * @Template()
     */
    public function passwordChangedAction()
    {
        return array();
    }

    /**
     * This actions allows the user to reset his password.
     *
     * @param Request $request The Request
     * @param string  $token   The password request token
     * @return array|RedirectResponse The Response or template variables
     *
     * @Route("/Account/Password/{token}", name="reset_password")
     * @Template()
     */
    public function resetPasswordAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ECENetagoraBundle:PasswordRequest');

        if (!$pwdRequest = $repository->getActiveRequest($token)) {
            throw $this->createNotFoundException(sprintf('Unable to find active password request identified by token "%s".', $token));
        }

        $reset = new ResetPassword();
        $form = $this->createForm(new ResetPasswordType(), $reset);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                // Change the password
                $factory = $this->get('security.encoder_factory');
                $user = $pwdRequest->getUser();
                $user->setPlainPassword($reset->getPassword());
                $user->encodePlainPassword($factory->getEncoder($user));
                $user->eraseCredentials();

                // Update the user and remove the password request
                $em->persist($user);
                $em->remove($pwdRequest);
                $em->flush();

                return $this->redirect($this->generateUrl('password_changed'));
            }
        }

        return array(
            'token' => $token,
            'form' => $form->createView()
        );
    }

    /**
     * This method authenticates the newly created user.
     *
     * @param User $user The User entity
     * @return void
     */
    private function authenticateUserToken(User $user)
    {
        $token = new UsernamePasswordToken($user->getUsername(), $user->getPassword(), 'public', $user->getRoles());
        $token->setUser($user);
        $this->get('security.context')->setToken($token);
    }

    /**
     * This method sends the confirmation email to the newly created user.
     *
     * @param User $user The User entity
     * @return void
     */
    private function sendConfirmationEmail(User $user)
    {
        $robotName  = $this->container->getParameter('robot_name');
        $robotEmail = $this->container->getParameter('robot_email');

        $body = $this->renderView(
            'ECENetagoraBundle:Notification:registration.txt.twig',
            array('user' => $user)
        );

        $message = \Swift_Message::newInstance()
            ->setFrom(array($robotEmail => $robotName))
            ->setTo(array($user->getEmail() => $user->getFullName()))
            ->setSubject('Welcome to the Netagora Social Platform')
            ->setBody($body)
        ;

        $this->get('mailer')->send($message);
    }

    /**
     * This method sends the confirmation email for the password change.
     *
     * @param PasswordRequest $request The password request entity
     * @return void
     */
    private function sendPasswordRequestEmail(PasswordRequest $request)
    {
        $robotName  = $this->container->getParameter('robot_name');
        $robotEmail = $this->container->getParameter('robot_email');

        $body = $this->renderView(
            'ECENetagoraBundle:Notification:password.txt.twig',
            array('token' => $request->getToken())
        );

        $message = \Swift_Message::newInstance()
            ->setFrom(array($robotEmail => $robotName))
            ->setTo($request->getEmail())
            ->setSubject('Netagora - Change your password')
            ->setBody($body)
        ;

        $this->get('mailer')->send($message);
    }
}
