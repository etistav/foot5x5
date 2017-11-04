<?php
// src/foot5x5/MainBundle/Form/Type/SliderNoteType.php

namespace foot5x5\MainBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderNoteType extends AbstractType
{
	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
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
