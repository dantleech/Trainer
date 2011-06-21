<?php
namespace DTL\TrainerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\FormView;
use DTL\TrainerBundle\Form\DataTransformer\StopwatchToSecondTransformer;

class StopwatchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->appendClientTransformer(new StopwatchToSecondTransformer())
            ->setAttribute('value', $options['value'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('value', $form->getClientData());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'value' => '00:00:00',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'field';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'stopwatch';
    }
}

