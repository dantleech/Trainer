<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionType extends AbstractType
{
    public function getName()
    {
        return 'session';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('activity');
        $builder->add('route');
        $builder->add('title');
        $builder->add('date', 'date');
        $builder->add('distanceIsEstimate', 'checkbox', array(
            'label' => 'Distance is estimate?',
            'required' => false,
        ));
        $builder->add('distance', 'distance');
        $builder->add('time', 'stopwatch');
        $builder->add('weight', 'number', array(
            'required' => false,
        ));
        $builder->add('labels', 'csv', array(
            'required' => false,
        ));
        $builder->add('log', 'textarea');
    }
}
