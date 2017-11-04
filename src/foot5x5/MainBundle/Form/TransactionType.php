<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'datePicker', array())
            ->add('giver', 'entity', array(
                'class' => 'foot5x5MainBundle:Player',
                'label' => 'Donneur',
                'property' => 'name',
                'multiple' => false
            ))
            ->add('receiver', 'entity', array(
                'class' => 'foot5x5MainBundle:Player',
                'label' => 'Receveur',
                'property' => 'name',
                'multiple' => false
            ))
            ->add('amount', 'number', array(
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_transaction';
    }
}
