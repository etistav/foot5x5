<?php
// src/foot5x5/MainBundle/Form/Type/PlayerDropType.php

namespace foot5x5\MainBundle\Form\Type;


// use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use foot5x5\MainBundle\Form\DataTransformer\PlayerToNameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected player does not exist',
        ));
    }
    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'playerDrop';
    }
}
