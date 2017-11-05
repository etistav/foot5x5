<?php
// src/foot5x5/MainBundle/Form/Type/DatePickerType.php

namespace foot5x5\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DatePickerType extends AbstractType
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
        return DateType::class;
    }

    public function getBlockPrefix()
    {
        return 'datePicker';
    }
}
