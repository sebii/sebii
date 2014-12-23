<?php

namespace Sbh\StartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Swift_Message;
use \PropelException;
use Sbh\StartBundle\Model\User;
use Sbh\StartBundle\Model\UserPeer;
use Sbh\StartBundle\Form\Type\RegistrationFormType;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class RegistrationController
{
    /**
     * action registration
     * 
     * formulaire d'inscription au site et enregistrement
     * @since 1.0.0 Création -- sebii
     * @access public
     * @Route("/login", name="login", defaults={"_lang"="fr"})
     * @Method({"GET"})
     * @param Request $request
     * @return object
     */
    public function registerAction(Request $request)
    {
        $user    = new User();
        $form    = $this->createForm(new RegistrationFormType(), $user);
        $session = $request->getSession();
        
        if ($request->isMethod('POST') && $form->handleRequest($request))
        {
            $user
                ->setUsername(trim($user->getUsername()))
                ->generateUsernameCanonical()
                ->generateSalt()
                ->generateActivationKey()
                ->setOrigin(UserPeer::ORIGIN_REGISTRATION);
            $factory  = $this->get('security.encoder_factory');
            $encoder  = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user
                ->setPassword($password)
                ->addRole('ROLE_USER');
            try
            {
                $user->save();
                $isUserCreated = true;
            }
            catch (PropelException $pe)
            {
                $session->getFlashBag()->add('error', 'registration.flash.register.error');
                $isUserCreated = false;
            }
            if ($isUserCreated === true)
            {
                $mailMessage = Swift_Message::newInstance()
                    ->setSubject($this->translate('registration.mail.registeractivate.subject'), array(
                            '%site_name%' => 'sebii.fr'
                    ))
                    ->setFrom($this->getConfigParameter('mailer_mailas'))
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView('SbhStartBundle:Registration:registrationActivateMail.html.twig', array(
                                '%username%'          => $user->getUsername(),
                                '%password%'          => $user->getPlainPassword(),
                                '%usernameCanonical%' => $user->getUsernameCanonical(),
                                '%activationKey%'     => $user->getActivationKey(),
                    )));
                $this->getMailer()->send($mailMessage);
                
                $session->getFlashBag()->add('success', 'registration.flash.register.success');
                $session->getFlashBag()->add('notice', 'registration.flash.register.info', array(
                        '%email%'        => $user->getEmail(),
                        '%mailSender%'   => $this->getConfigParameter('mailer_mailas'),
                        '%mailProvider%' => $this->getConfigParameter('mailer_user'),
                ));
                return $this->redirect($this->generateUrl('home'));
            }
            else
            {
                foreach ($user->getValidationFailures() as $failureMessage)
                {
                    $session->getFlashBag()->add('error', $failureMessage);
                }
            }
        }
        
        return $this->render('IimAdminBundle:Registration:register.html.twig', array(
                'form' => $form->createView(),
        ));
    }
}
