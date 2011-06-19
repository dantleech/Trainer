<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description');
        $builder->add('distance');
    }
}
