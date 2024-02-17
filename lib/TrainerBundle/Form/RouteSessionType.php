<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteSessionType extends AbstractType
{
    public function getName()
    {
        return 'route_session';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rankedBy = $options['route']->getRankedBy();
        $builder->add('date', 'datetime');
        $builder->add($rankedBy, $rankedBy == 'time' ? 'stopwatch' : 'distance');
        $builder->add('log', 'textarea');
        $builder->add('weight', 'number', array(
            'required' => false,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefault('route', null);
    }
}
