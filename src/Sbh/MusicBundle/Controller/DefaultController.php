<?php

namespace Sbh\MusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SbhMusicBundle:Default:index.html.twig', array('name' => $name));
    }
}
