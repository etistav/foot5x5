<?php
// src/foot5x5/MainBundle/Form/Type/PlayerDropType.php

namespace foot5x5\MainBundle\Form\Type;


// use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use foot5x5\MainBundle\Form\DataTransformer\PlayerToNameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlayerDropType extends AbstractType
{
    protected $class;
    protected $repo;

    public function __construct($class, EntityManager $em)
    {
        $this->class = $class;
        $this->repo = $em->getRepository($class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new PlayerToNameTransformer($this->repo);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected player does not exist',
        ));
    }
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'playerDrop';
    }
}
