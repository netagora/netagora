<?php

namespace ECE\Bundle\BetaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        //Test send mail
        $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('no-reply@netagora.net')
                ->setTo('mkhalil.sarah@gmail.com')
                ->setBody($this->renderView('ECEBetaBundle:Default:email.html.twig', array('name' => 'name')))
            ;
            $this->get('mailer')->send($message);
        return array();
    }
}
