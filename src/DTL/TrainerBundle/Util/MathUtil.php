<?php

namespace DTL\TrainerBundle\Util;

class MathUtil
{
    public static function average($v1, $v2)
    {
        if (!$v1) {
            return 0;
        }

        if (!$v2) {
            return 0;
        }

        return $v1 / $v2;
    }
}
