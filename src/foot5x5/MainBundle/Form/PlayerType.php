<?php
// src/foot5x5/MainBundle/Form/PlayerType.php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom'
            ))
            ->add('valAtt', 'number', array(
                'label' => 'Note Attaque',
                'precision' => '2',
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('valDef', 'number', array(
                'label' => 'Note Défense',
                'precision' => '2',
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('valPhy', 'number', array(
                'label' => 'Note Physique',
                'precision' => '2',
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('cashBalance', 'number', array(
                'label' => 'Solde en €',
                'precision' => '2',
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('isActive', 'checkbox', array(
                'label' => 'En activité',
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Player'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_player';
    }
}
