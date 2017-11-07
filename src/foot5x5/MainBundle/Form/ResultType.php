<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use foot5x5\MainBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ResultType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreTeamA', NumberType::class)
            ->add('scoreTeamB', NumberType::class)
            ->add('date', DatePickerType::class, array())
            ->add('matchPlayers', CollectionType::class, array(
                'entry_type' => MatchPlayerType::class,
                'label' => false,
                'entry_options' => array(
                    'label' => false
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Result'
        ));
    }
}
