<?php

namespace Sbh\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * 
     * @Route("/{_lang}", name="home", requirements={"_lang"="\w{2}"}, defaults={"_lang"="fr"})
     */
    public function indexAction()
    {
        return $this->render('SbhMainBundle:Main:index.html.twig');
    }
}
