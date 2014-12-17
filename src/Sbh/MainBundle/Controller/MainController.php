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
    
    /**
     * 
     * @Route("/{_lang}/htmlspchars", name="sbh_main_main_htmlspecialchars", requirements={"_lang"="\w{2}"}, defaults={"_lang"="fr"})
     */
    public function htmlspecialcharsAction()
    {
        return $this->render('SbhMainBundle:Main:htmlspecialchars.html.twig');
    }
}
