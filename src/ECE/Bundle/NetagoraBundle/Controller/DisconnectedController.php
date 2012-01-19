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
        $session = $request->getSession();
        $twitter = unserialize($session->get('twitter'));
        
        $twitter_id = $session->get('twitter_id');
        
        if(isset($twitter_id)){
            
            $q = $em->createQuery('SELECT u.id, u.username, u.email, u.picture, u.location, u.firstName, u.lastName, u.birthdate, u.registeredAt, u.twitterID, u.twitterUsername FROM ECENetagoraBundle:User u WHERE u.twitterID = :twitterID');
            $q->setParameter('twitterID', $session->get('twitter_id'));
            $userDB = $q->getResult();
            $userConnected = new User();
            $userConnected = User::hydrateObject($userDB);
            
        }

        if(isset($twitter) && isset($twitter_id)){ 
            $count = 2;
            //Get all publications from Twitter
            $array = $twitter->get('statuses/home_timeline', array('screen_name' => $session->get('info')->screen_name,'count' => $count));
            //Get all publications from the database
            $query = $em->createQuery('SELECT p FROM ECENetagoraBundle:Publication p');
            $publications = $query->getResult();

            for($i=0; $i<$count; $i++){
                //If publication content a link
                if(Publication::isLinkPublication($array[$i]->text) == true){
                    $newPublication = new Publication();
                    //Get link from the publication
                    preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',$array[$i]->text,$link);
                    $createdAt = new \DateTime($array[$i]->created_at, new \DateTimeZone("Europe/Paris"));
                    //If there is at least one publication in database
                    if(count($publications) > 0){
                        $flag = false;
                        $debug = $debug.'<br />PUBLICATIONS IN DB |';
                        //Foreach publication in DB
                        for($j=0; $j<count($publications); $j++){
                            //if publication doesn't already exist in DB - check the tweet ID
                            if($publications[$j]->getReference() == $array[$i]->id_str){
                                $debug = $debug.'<br />THIS PUBLICATION ALREADY EXISTS<br />';
                                $flag = 'true'; //publication already exists in DB
                            }
                        
                        }
                    }
                    
                    //If there is no publication in DB or the publication does not exist in DB
                    if(count($publications) == 0 || $flag == false){
                        $debug = $debug.'<br />Hydratation Object Publication |';
                        $newPublication->setAuthor($array[$i]->user->name);
                        //$newPublication->setUser($userConnected); 
                        //=>Got that error 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'Saro0h' for key 'UNIQ_A2FBC267A0D96FBF' 
                        $newPublication->setPublishedAt($createdAt);
                        $newPublication->setReference($array[$i]->id_str);
                        $newPublication->setContent($array[$i]->text);
                        $newPublication->setLinkUrl($link[0][0]);
                        $newPublication->setSocialNetwork('twitter');
                        $newPublication->setKnownLink('-1');
                        $em->persist($newPublication);
                        $em->flush();
                        $debug = $debug.'Save done. ID publication: '.$newPublication->getId().'<br />';
                    }
                }
               
            }
        }
        
        /* Subscribe form */
        $entity  = new User();
        $form= $this->createForm(new UserType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $entity->setPassword(md5($entity->getPassword()));//Encode password in md5
            $entity->setLastLogin(new \DateTime());
            $entity->upload();
            //Update the user $this->manager->updateUser($user);
            $em->persist($entity);
            $em->flush();
            //set session
            $session->set('user_id', $entity->getId());

            //return $this->redirect($this->generateUrl('home', array('username' => $entity->getUsername()), 301);//permanent redirection
        }
        
        return $this->render('ECENetagoraBundle:Disconnected:subscribe.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'debug'  => $debug,
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
