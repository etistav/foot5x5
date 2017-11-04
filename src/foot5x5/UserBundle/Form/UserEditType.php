<?php

namespace foot5x5\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('roles', ChoiceType::class, array(
            		'choices' => array(
            			'Admin' => 'ROLE_ADMIN',
            			'Evaluateur' => 'ROLE_EVALUATOR',
            			'Player' => 'ROLE_USER',
            		),
            		'choices_as_values' => true,
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
}
