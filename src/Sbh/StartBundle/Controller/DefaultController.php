<?php

namespace Sbh\StartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SbhStartBundle:Default:index.html.twig', array('name' => $name));
    }
}
