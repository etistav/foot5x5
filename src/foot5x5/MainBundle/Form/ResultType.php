<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use foot5x5\MainBundle\Form\MatchPlayerType;

class ResultType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreTeamA', 'number')
            ->add('scoreTeamB', 'number')
            ->add('date', 'datePicker', array())
            ->add('matchPlayers', 'collection', array(
                'type' => new MatchPlayerType(),
                'label' => false,
                'options' => array(
                    'label' => false
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Result'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_result';
    }
}
