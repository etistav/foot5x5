<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use foot5x5\MainBundle\Form\DataTransformer\PlayerToNameTransformer;

class MatchPlayerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('player', 'entity', array(
            //     'class' => 'foot5x5MainBundle:Player',
            //     'property' => 'name',
            //     'multiple' => false
            // ))
            ->add(
                'player',
                'playerDrop',
                array(
                    'required' => true
                )
            )
            ->add('team', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\MatchPlayer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_matchplayer';
    }
}
