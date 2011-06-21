<?php

namespace DTL\TrainerBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StopwatchValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        return true;
        $this->setMessage($constraint->message);

        if (preg_match('&^([0-9]{1,5}):([0-9]{1,2}):([0-9]{1,2})$&', $value, $matches)) {
            if ($matches[2] > 59) {
                return false;
            }

            if ($matches[3] > 59) {
                return false;
            }

            return true;
        }

        return false;
    }
}
