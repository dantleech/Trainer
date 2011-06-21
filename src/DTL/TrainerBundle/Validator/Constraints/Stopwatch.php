<?php

namespace DTL\TrainerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Stopwatch extends Constraint
{
    public $message = 'Time must be formated as HH:MM:SS';
}
