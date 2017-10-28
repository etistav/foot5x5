<?php
// src/foot5x5/MainBundle/Form/Type/SliderNoteType.php

namespace foot5x5\MainBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderNoteType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
    }
    public function getParent()
    {
        return 'number';
    }

    public function getName()
    {
        return 'sliderNote';
    }
}
