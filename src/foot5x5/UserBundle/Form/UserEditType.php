<?php

namespace foot5x5\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'label' => 'Prénom'
            ))
            ->add('lastname', 'text', array(
                'label' => 'Nom'
            ))
            ->add('birthday', 'birthday', array(
                'label' => 'Date de naissance'
            ))
            ->add('username', 'text')
            ->add('roles', 'choice', array(
                'choices' => array(
                    'ROLE_ADMIN' => 'Admin',
                    'ROLE_EVALUATOR' => 'Evaluateur',
                    'ROLE_USER' => 'Player'
                ),
                'required' => true,
                'multiple' => true,
                'expanded' => true
            ))
            ->add('player', 'entity', array(
                'class' => 'foot5x5MainBundle:Player',
                'property' => 'name',
                'multiple' => false
            ))
            ->add('file', 'file', array(
                'label' => 'Photo de profil',
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_userbundle_user';
    }
}
