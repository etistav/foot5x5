<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use foot5x5\MainBundle\Form\Type\SliderNoteType;

class NoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valAtt', SliderNoteType::class, array(
                'label' => 'Note Attaque'
            ))
            ->add('valDef', SliderNoteType::class, array(
                'label' => 'Note Défense'
            ))
            ->add('valPhy', SliderNoteType::class, array(
                'label' => 'Note Physique'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Note'
        ));
    }
}
