<?php
// src/foot5x5/MainBundle/Form/PlayerType.php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class PlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('valAtt', NumberType::class, array(
                'label' => 'Note Attaque',
                'scale' => 2,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('valDef', NumberType::class, array(
                'label' => 'Note Défense',
                'scale' => 2,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('valPhy', NumberType::class, array(
                'label' => 'Note Physique',
                'scale' => 2,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('cashBalance', NumberType::class, array(
                'label' => 'Solde en €',
                'scale' => 2,
                'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            ))
            ->add('isActive', CheckboxType::class, array(
                'label' => 'En activité',
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
            'data_class' => 'foot5x5\MainBundle\Entity\Player'
        ));
    }

}
