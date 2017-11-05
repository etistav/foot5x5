<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use foot5x5\MainBundle\Form\Type\DatePickerType;

class TransactionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DatePickerType::class, array())
            ->add('giver', EntityType::class, array(
                'class' => 'foot5x5MainBundle:Player',
                'label' => 'Donneur',
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('receiver', EntityType::class, array(
                'class' => 'foot5x5MainBundle:Player',
                'label' => 'Receveur',
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('amount', NumberType::class, array(
                'label' => 'Montant en €'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Transaction'
        ));
    }

}
