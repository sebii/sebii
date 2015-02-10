<?php

namespace Sbh\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SbhBankBundle:Default:index.html.twig', array('name' => $name));
    }
}
