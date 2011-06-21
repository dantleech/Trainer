<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('activity');
        $builder->add('title');
        $builder->add('route');
        $builder->add('date');
        $builder->add('log');
        $builder->add('distance', 'distance');
        $builder->add('time', 'stopwatch');
    }
}
