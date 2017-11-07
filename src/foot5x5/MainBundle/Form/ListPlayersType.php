<?php
// src/foot5x5/MainBundle/Form/ListPlayersType.php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListPlayersType extends AbstractType
{
    /*
    private $players;

    public function __construct(array $players)
    {
        $this->players = $players;
    }
    */

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('players', 'collection', array(
                'type' => new PlayerType()
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_listplayers';
    }
}
