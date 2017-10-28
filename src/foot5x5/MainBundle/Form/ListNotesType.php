<?php
// src/foot5x5/MainBundle/Form/ListNotesType.php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use foot5x5\MainBundle\Form\NoteType;

class ListNotesType extends AbstractType
{
    /*
    private $notes;

    public function __construct(array $notes)
    {
        $this->notes = $notes;
    }
    */

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('notes', 'collection', array(
                'type' => new NoteType()
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_listnotes';
    }
}
