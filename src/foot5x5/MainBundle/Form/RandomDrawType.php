<?php
// src/foot5x5/MainBundle/Form/RandomDrawType.php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class RandomDrawType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('players', 'collection', array(
            //     'type' => new PlayerType()
            // ))
            // ->add('players', 'entity', array(
            //     'class'    => 'foot5x5MainBundle:Player',
            //     'property' => 'name',
            //     'multiple' => true,
            //     'expanded' => true
            // ))
            ->add('selectedPlayers', HiddenType::class)
        ;
    }

}