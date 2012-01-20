<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends Controller
{
    /**
     * @Route("/Documentation", name="documentation")
     * @Template()
     */
    public function documentationAction()
    {
        return array();
    }
    
    /**
     * @Route("/Contribution", name= "contribution")
     * @Template()
     */
    public function contributionAction()
    {
        return array();
    }
    
    /**
     * @Route("/About", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Route("/Credits", name="credits")
     * @Template()
     */
    public function creditsAction()
    {
        return array();
    }
    
    /**
     * @Route("/Badges", name="badges")
     * @Template()
     */
    public function badgesAction()
    {
// PROFIL USER : Badges forme: 1,2,3
   // badges_num = explode(",",user->badge);
   
   // TABLE badge: id, url, name
   // badges_infos : recup de DB badges	   
   
   // num = 0;
   // pour les badges du user
   // for(i=0;i<count(badges_num);i++){
   //     on fait le tour du numéro de tous les badges
   //     for(j=0;j<count(badges_info); j++)
   //          si le numéro d'un des badges correspond au numéro de celui du user
   //          if (badges_num[i] ==  badges_info[j]["id"]
   //				on récupère les infos du badge
   //				badges[num] = badges_info[j];
   //				on augmente num
   //				num ++
   
   // ensuite on met l'url dans un array a retourner
   // $badges_list = "";
   // for(i=0; i<num; i++)
   //      $badges_list .= '"' . badges[url] . '"';
   //      if(i<num-1) $badges_list .= ",";
   // $badges = array($badges_list);

   $badges = array("../bundles/ecenetagora/images/badges/pioneer.png","../bundles/ecenetagora/images/badges/pioneer.png");
   return array('badges' => $badges);
    }
}
