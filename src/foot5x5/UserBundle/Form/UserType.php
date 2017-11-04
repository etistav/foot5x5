<?php

namespace foot5x5\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    		if ($options['action'] = "register") {
    			$builder
    			->add('firstname', 'text', array(
    					'label' => 'Prénom'
    			))
    			->add('lastname', 'text', array(
    					'label' => 'Nom'
    			))
    			->add('username', 'text')
    			->add('email', 'email')
    			->add('password', 'repeated', array(
    					'type'            => 'password',
    					'invalid_message' => 'The password fields must match.',
    					'options'         => array('required' => true),
    					'first_options'   => array('label' => 'Password'),
    					'second_options'  => array('label' => 'Repeat password'),
    			))
    			->add('birthday', 'birthday', array(
    					'label' => 'Date de naissance',
    					'widget' => 'choice',
    					'placeholder' => array(
    							'year' => 'yyyy', 'month' => 'mm', 'day' => 'dd',
    					),
    					'format' => 'dd/MM/yyyy',
    					'years' => range(date('Y'), date('Y')-70)
    			));
    		} else {
    			$builder
    			->add('firstname', 'text', array(
    					'label' => 'Prénom'
    			))
    			->add('lastname', 'text', array(
    					'label' => 'Nom'
    			))
    			->add('birthday', 'birthday', array(
    				'label' => 'Date de naissance',
				'placeholder' => array(
						'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
				)
    			))
    			->add('username', 'text')
    			->add('email', 'text')
    			->add('password', 'repeated', array(
    					'type'            => 'password',
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_userbundle_user';
    }
}
