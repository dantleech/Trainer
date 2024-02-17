<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WeightType extends AbstractType
{
    public function getName()
    {
        return 'weight';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('date', 'datetime');
        $builder->add('weight');
        $builder->add('comment');
    }
}

