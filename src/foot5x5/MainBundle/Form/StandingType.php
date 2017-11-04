<?php

namespace foot5x5\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandingType extends AbstractType
{
    //private $standings;

    //public function __construct(array $standings)
    //{
    //    $this->standings = $standings;
    //}

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm_old(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('trimester')
            ->add('nbMatch')
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$players = $this->playerDAO->listAll();
        //$standings = $this->standings;
        //$standingsName = array();
        //$standingsId = array();
        //foreach ($standings as $standing) {
        //    $standingName = 'T0'.$standing->getTrimester().' - '.$standing->getYear();
        //    $standingsName[] = $standingName;
        //    $standingsId[] = $standing->getId();
        //}
        //$standingsName = array_combine($standingsId, $standingsName);

        $builder->add(
            'stdCombo',
            'entity',
            array(
                'class' => 'foot5x5MainBundle:Standing',
                'label' => 'Trimestre',
                'placeholder' => 'Choisir...'
            )
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'foot5x5\MainBundle\Entity\Standing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foot5x5_mainbundle_standing';
    }
}
