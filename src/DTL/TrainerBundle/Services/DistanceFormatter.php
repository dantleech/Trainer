<?php

namespace DTL\TrainerBundle\Services;
use DTL\TrainerBundle\Util\MathUtil;

class DistanceFormatter
{
    public function format($meters)
    {
        // return KM for now
        return $meters / 1000;
    }
}
