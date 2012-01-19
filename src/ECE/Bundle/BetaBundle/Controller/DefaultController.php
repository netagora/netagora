<?php

namespace ECE\Bundle\BetaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ECE\Bundle\BetaBundle\Entity\Emailing;
use ECE\Bundle\BetaBundle\Form\EmailingType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $email = $request->request->get('email');
        $emailing  = new Emailing();
        $emailing->setEmail($email);
        
        //Validation
        $validator = $this->get('validator');
        if (!count($validator->validate($emailing))) {
            $em = $this->getDoctrine()->getEntityManager();
            $result = $em->getRepository('ECEBetaBundle:Emailing')->findOneByEmail($emailing->getEmail());
            if (!$result) {
                $em->persist($emailing);
                $em->flush();
                
                
                /*$message = \Swift_Message::newInstance()
                        ->setSubject('Stay tuned!')
                        ->setFrom(array('no-reply@netagora.net'=>'Netagora Team'))
                        ->setTo($emailing->getEmail())
                        ->setBody($this->renderView('ECEBetaBundle:Default:email.html.twig'))
                    ;
                $this->get('mailer')->send($message);*/

                return $this->redirect($this->generateUrl('success-email'));
            }
        }
        
        return $this->render('ECEBetaBundle:Default:index.html.twig', array());
    }
}
