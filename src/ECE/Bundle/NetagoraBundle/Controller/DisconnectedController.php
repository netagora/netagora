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
                        //redirection vers Home
                        $debug = $debug.'Save done. ID publication: '.$newPublication->getId().'<br />';
                    }
                }
               
            }
        }
        
        /* Subscribe form */
        $error = '';
        $entity  = new User();
        $entity->setUsername('Enter your username');
        
        $form = $this->createForm(new UserType(), $entity);
        
        if ($request->request->get('password') != $request->request->get('password_again')) {
            $error = 'Your must type the same password twice <br />';
        }
        
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
            'debug'  => $debug,
            'error'  => $error,
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
     * @Route("/PasswordRetrieval", name="forgot")
     * @Template()
     */
    public function passwordRetrievalAction(Request $request)
    {
        $error = '';
        $debug = '';
        //Renvoie le mot de passe en clair dans le mail
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
        } else {
            $error = 'Your account doesn\'t exist';
        }
        
        return array('error'=>$error, 'debug' => $debug);
    }
}
