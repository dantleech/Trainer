<?php

namespace DTL\TrainerBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CsvToArrayTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if ($value) {
            return implode(',', $value);
        }
    }

    /**
     * Transforms a string into a Boolean.
     *
     * @param  string $value  String value.
     *
     * @return Boolean        Boolean value.
     *
     * @throws UnexpectedTypeException if the given value is not a string
     */
    public function reverseTransform($value)
    {
        if ($value) {
            return explode(',', $value);
        }
    }
}

