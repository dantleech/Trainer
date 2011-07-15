<?php

namespace DTL\TrainerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ActivityType extends AbstractType
{
    public function getName()
    {
        return 'activity';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('icon');
    }
}
