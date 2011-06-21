<?php

namespace DTL\TrainerBundle\Util;

class FormatUtil
{
    public static function secondsToStopwatch($seconds)
    {
        $hours = floor($seconds / 60 / 60);
        $minutes = floor(($seconds - ($hours * 60 * 60)) / 60);
        $seconds = $seconds - (($hours * 60 * 60) + ($minutes * 60));
        $res = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        return $res;
    }

    public static function stopwatchToSeconds($stopwatch)
    {
        if (preg_match('&^([0-9]*):([0-9]{1,2}):([0-9]{1,2})$&', $stopwatch, $matches)) {
            $seconds = $matches[1] * 60 * 60;
            $seconds += $matches[2] * 60;
            $seconds += $matches[3];
            return $seconds;
        }

        $seconds = strtotime($stopwatch) - time();
        return $seconds;
    }

    public static function distanceToMeters($distance, $defaultUnit = 'kilometer')
    {
        $distance = strtolower(trim($distance));
        $unit = null;

        if (!preg_match('&^[0-9]+([a-z])&', $distance)) {
            $unit = $defaultUnit;
        }

        if (preg_match('&^([0-9]+)\s*(k|km|kilo|kilometers|kilometres)$&', $distance, $matches)) {
            $unit = 'kilometer';
            $distance = $matches[1];
        }

        if (preg_match('&^([0-9]+)\s*(ml|mile|miles)$&', $distance, $matches)) {
            $unit = 'mile';
            $distance = $matches[1];
        }

        if (preg_match('&^([0-9]+)\s*(m|meter|meters)$&', $distance, $matches)) {
            $unit = 'meter';
            $distance = $matches[1];
        }

        if ($unit == 'meter') {
            return $distance;
        }

        if ($unit == 'mile') {
            $con = $distance * 1609.344;
            return $con;
        }

        if ($unit == 'kilometer') {
            $con = $distance * 1000;
            return $con;
        }
    }

    public static function metersToDistance($meters, $unit = 'kilometer')
    {
        $con = $meters / 1000;
        $formatted = sprintf('%s%s', number_format($con, 2), 'km');
        return $formatted;
    }
}
