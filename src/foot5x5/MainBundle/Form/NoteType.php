<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valAtt', 'sliderNote', array(
                'label' => 'Note Attaque'
            ))
            ->add('valDef', 'sliderNote', array(
                'label' => 'Note Défense'
            ))
            ->add('valPhy', 'sliderNote', array(
                'label' => 'Note Physique'
            ))
            // ->add('valDef', 'number', array(
            //     'label' => 'Note Défense',
            //     'precision' => '2',
            //     'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            // ))
            // ->add('valPhy', 'number', array(
            //     'label' => 'Note Physique',
            //     'precision' => '2',
            //     'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP
            // ))
            // ->add('valAvg', 'number', array(
            //     'label' => 'Note Moyenne',
            //     'precision' => '2',
            //     'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_HALFUP,
            //     'disabled' => true
            // ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Note'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_note';
    }
}
