<?php

namespace DTL\TrainerBundle\Form;

use DTL\TrainerBundle\Form\Type\DistanceType;
use DTL\TrainerBundle\Form\Type\StopwatchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
        $builder->add('date', DateTimeType::class);
        $builder->add($rankedBy, $rankedBy == 'time' ? StopwatchType::class : DistanceType::class);
        $builder->add('log', TextType::class);
        $builder->add('weight', NumberType::class, array(
            'required' => false,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('route', null);
    }
}
