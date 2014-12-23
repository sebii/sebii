<?php

namespace Sbh\StartBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * 
 * @version 1.0.0
 * @author Sébastien "sebii" Bloino <sebii@sebiiheckel.fr>
 */
class RegistrationFormType extends AbstractType
{
    /**
     * build form
     * 
     * Contruction du formulaire d'inscription
     * @access public
     * @since 1.0.0 Création -- sebii
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('plainPassword', 'repeated', array('type' => 'password'))
            ->add('create', 'submit');
    }
    
    /**
     * set default options
     * 
     * paramétrage des options par défaut
     * @access public
     * @since 1.0.0 Création -- sebii
     * @param OptionsResolverInterface $resolver
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Sbh\StartBundle\Model\User',
        ));
    }
    
    /**
     * get name
     * 
     * retourne le nom du formulaire
     * @access public
     * @since 1.0.0 Création -- sebii
     * @return string
     */
    public function getName()
    {
        return 'registration';
    }
}
