<?php

namespace DTL\TrainerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class Stopwatch extends Constraint
{
    public $message = 'Time must be formated as HH:MM:SS';
}
