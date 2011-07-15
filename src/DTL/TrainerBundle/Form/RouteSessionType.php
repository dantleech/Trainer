<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RouteSessionType extends AbstractType
{
    public function getName()
    {
        return 'route_session';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $rankedBy = $options['route']->getRankedBy();
        $builder->add('date', 'datetime');
        $builder->add($rankedBy, $rankedBy == 'time' ? 'stopwatch' : 'distance');
        $builder->add('log', 'textarea');
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['route'] = null;
        return $options;
    }
}
