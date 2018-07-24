<?php

namespace foot5x5\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    		if ($options['action'] == "register") {
    			$builder
    			->add('firstname', TextType::class, array(
    					'label' => 'Prénom'
    			))
    			->add('lastname', TextType::class, array(
    					'label' => 'Nom'
    			))
    			->add('username', TextType::class, array(
    					'label' => 'Pseudo'
    			))
    			->add('email', EmailType::class)
    			->add('password', RepeatedType::class, array(
    					'type'            => PasswordType::class,
    					'invalid_message' => 'The password fields must match.',
    					'options'         => array('required' => true),
    					'first_options'   => array('label' => 'Mot de passe'),
    					'second_options'  => array('label' => 'Confirmation'),
    			))
    			->add('birthday', BirthdayType::class, array(
    					'label' => 'Date de naissance',
    					'widget' => 'choice',
    					'placeholder' => array(
    							'year' => 'yyyy', 'month' => 'mm', 'day' => 'dd',
    					),
    					'format' => 'dd/MM/yyyy',
    					'years' => range(date('Y'), date('Y')-70)
    			));
    		} elseif ($options['action'] == "edit") {
    			$builder
    			->add('firstname', TextType::class, array(
    					'label' => 'Prénom'
    			))
    			->add('lastname', TextType::class, array(
    					'label' => 'Nom'
    			))
    			->add('birthday', BirthdayType::class, array(
    					'label' => 'Date de naissance',
    					'widget' => 'choice',
    					'placeholder' => array(
    							'year' => 'yyyy', 'month' => 'mm', 'day' => 'dd',
    					),
    					'format' => 'dd/MM/yyyy',
    					'years' => range(date('Y'), date('Y')-70)
    			))
    			->add('username', TextType::class)
    			->add('email', EmailType::class)
    			/*
    			->add('roles', ChoiceType::class, array(
    					'choices' => array(
    							'Admin' => 'ROLE_ADMIN',
    							'Evaluateur' => 'ROLE_EVALUATOR',
    							'Player' => 'ROLE_USER',
    					),
    					'choices_as_values' => true,
    					'required' => true,
    					'multiple' => true
    			))
    			*/
    			->add('userRoles', EntityType::class, array(
    			    'class' => 'foot5x5MainBundle:Roles',
    			    'choice_label' => 'role',
    			    'multiple' => false
    			))
    			->add('player', EntityType::class, array(
    					'class' => 'foot5x5MainBundle:Player',
    					'choice_label' => 'name',
    					'multiple' => false
    			))
    			->add('file', FileType::class, array(
    					'label' => 'Photo de profil',
    					'required' => false
    			));
    		} else {
    			$builder
    			->add('firstname', TextType::class, array(
    					'label' => 'Prénom'
    			))
    			->add('lastname', TextType::class, array(
    					'label' => 'Nom'
    			))
    			->add('birthday', BirthdayType::class, array(
    					'label' => 'Date de naissance',
    					'widget' => 'choice',
    					'placeholder' => array(
    							'year' => 'yyyy', 'month' => 'mm', 'day' => 'dd',
    					),
    					'format' => 'dd/MM/yyyy',
    					'years' => range(date('Y'), date('Y')-70)
    			))
    			->add('username', TextType::class)
    			->add('email', EmailType::class)
    			->add('password', RepeatedType::class, array(
    					'type'            => PasswordType::class,
    					'invalid_message' => 'The password fields must match.',
    					'options'         => array('required' => true),
    					'first_options'   => array('label' => 'Password'),
    					'second_options'  => array('label' => 'Repeat password'),
    			))
    			->add('roles', ChoiceType::class, array(
    					'choices' => array(
    						'Admin' => 'ROLE_ADMIN',
    						'Evaluateur' => 'ROLE_EVALUATOR',
    						'Player' => 'ROLE_USER',
    					),
    					'choices_as_values' => true,
    					'required' => true,
    					'multiple' => true
    			))
    			->add('player', EntityType::class, array(
    					'class' => 'foot5x5MainBundle:Player',
    					'choice_label' => 'name',
    					'multiple' => false
    			))
    			->add('file', FileType::class, array(
    					'label' => 'Photo de profil',
    					'required' => false
    			));
    		}
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
