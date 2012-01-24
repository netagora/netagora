<?php

namespace ECE\Bundle\NetagoraBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DemoController extends Controller
{
    /**
     * @Route("/buzz", name="buzz")
     */
    public function buzzAction(Request $request)
    {
        $buzz = $this->get('buzz');
        $response = $buzz->get('http://t.co/5bkpWynb');
        $uris = explode("\n", $response->getHeader('Location'));
        var_dump(array_pop($uris));
        die;

        var_dump((string) $response);
        die;
    }
}