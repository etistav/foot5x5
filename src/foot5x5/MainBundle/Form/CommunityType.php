<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use foot5x5\MainBundle\Form\Type\SliderNoteType;

class CommunityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('name', TextType::class, array(
				'label' => 'Nom de la communauté'
            ))
            ->add('matchPrice', NumberType::class, array(
                'label' => 'Prix match',
                'scale' => 1
            ))
            /*
            ->add('minAttendanceRate', PercentType::class, array(
                'label' => 'Taux d\'apparition min.',
                'type' => 'fractional',
                'scale' => 0
            ))
            */
            ->add('minAttendanceRate', SliderNoteType::class, array(
                'label' => 'Taux d\'apparition min.'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Community'
        ));
    }

}
