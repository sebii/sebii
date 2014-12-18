<?php

namespace Sbh\StartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\DisabledException;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class SecurityController extends Controller
{
    /**
     * action login
     * 
     * action login
     * @since 1.0.0 Création -- sebii
     * @access public
     * @Route("/login", name="login", defaults={"_lang"="fr"})
     * @Method({"GET"})
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return object
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        
        /* Récupérer l'erreur lors du login si elle existe */
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        /* Affichage de l'erreur */
        if ($error instanceof BadCredentialsException)
        {
            $session->getFlashBag()->add('error', 'security.flash.error.badcredentials');
        }
        elseif ($error instanceof DisabledException)
        {
            $session->getFlashBag()->add('error', 'security.flash.error.disabled');
        }
        elseif ($error)
        {
            $session->getFlashBag()->add('info', 'error login ' . gettype(error));
        }
        
        return $this->render('SbhStartBundle:Security:login.html.twig', array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
        ));
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return void
     * @Route("/login/check", name="login_check", defaults={"_lang"="fr"})
     * @Method({"POST"})
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * 
     * @since 1.0.0 Création -- sebii
     * @access public
     * @return void
     * @Route("/logout", name="logout", defaults={"_lang"="fr"})
     * @Method({"GET"})
     */
    public function logoutAction()
    {
    }
}