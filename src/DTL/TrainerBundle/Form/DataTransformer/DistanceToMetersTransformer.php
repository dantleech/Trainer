<?php

namespace DTL\TrainerBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use DTL\TrainerBundle\Util\FormatUtil;

class DistanceToMetersTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if ($value) {
            return FormatUtil::metersToDistance($value, 'kilometer');
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
            return FormatUtil::distanceToMeters($value);
        }
    }
}

