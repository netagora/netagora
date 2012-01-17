<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session;
use ECE\Bundle\NetagoraBundle\Entity\User;
use ECE\Bundle\NetagoraBundle\Form\UserType;
use Sensio\Bundle\BuzzBundle\DependencyInjection\SensioBuzzExtension;
use Symfony\Component\HttpFoundation\Response;
use ECE\Bundle\NetagoraBundle\Security\User\Provider\TwitterUserProvider;

class DisconnectedController extends Controller
{
    /**
     * @Route("/Subscribe")
     * @Template()
     */
    public function subscribeAction()
    {
        echo 'SubscribeAction';

        $request = $this->getRequest();
        $session = $request->getSession();
        $twitter = unserialize($session->get('twitter'));
        
        if(isset($twitter)){
            $homeTimeline = $twitter;//->get('statuses/home_timeline', array('screen_name' => $session->get('info')->screen_name,'count' => '5'));
            $array = $homeTimeline->get('statuses/home_timeline', array('screen_name' => $session->get('info')->screen_name,'count' => '5'));
            for($i=0; $i<5; $i++){
                echo '<pre>';
                var_dump($array[$i]->user->name);
                var_dump($array[$i]->id_str);
                echo '</pre>';
            }
        }
        
        $entity  = new User();
        
        $form= $this->createForm(new UserType(), $entity);
        
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setPassword(md5($entity->getPassword()));//Encode password in md5
            $entity->setLastLogin(new \DateTime());
            
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();
            //set session
            $session ->set('user_id', $entity->getId());

            //return $this->redirect($this->generateUrl('home', array('username' => $entity->getUsername()), 301);//permanent redirection
            //return new Response ( 'response' );
            
        }
       // echo md5(uniqid(rand(), true));
        
       // $response = new Response('http://twitter.com/statuses/home_timeline.json?oauth_nonce='.md5(uniqid(rand(), true)).'&oauth_timestamp='.time().'.&oauth_consumer_key=28322862-Y6jYufo8nKCoNVQyNS6OtT1QhQseVJKlEPAE59lyI&oauth_signature=IEVa4xAkK5ySzBEuTNvfueiqSG0%3D ');
       // echo '<br /> response';
       // var_dump($response);
        echo '<br />';
        
        return $this->render('ECENetagoraBundle:Disconnected:subscribe.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
