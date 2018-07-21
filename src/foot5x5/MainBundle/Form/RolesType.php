<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_EVALUATOR' => 'ROLE_EVALUATOR',
                    'ROLE_USER' => 'ROLE_USER',
                ),
                'choices_as_values' => true,
                'required' => true,
                'multiple' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Roles'
        ));
    }
}
