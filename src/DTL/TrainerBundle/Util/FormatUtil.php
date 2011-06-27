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

        if (!preg_match('&^[0-9\.]+([a-z])&', $distance)) {
            $unit = $defaultUnit;
        }

        if (preg_match('&^([0-9\.]+)\s*(k|km|kilo|kilometers|kilometres)$&', $distance, $matches)) {
            $unit = 'kilometer';
            $distance = $matches[1];
        }

        if (preg_match('&^([0-9\.]+)\s*(ml|mile|miles)$&', $distance, $matches)) {
            $unit = 'mile';
            $distance = $matches[1];
        }

        if (preg_match('&^([0-9\.]+)\s*(m|meter|meters)$&', $distance, $matches)) {
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

    public static function distanceOfTimeInWords($from_time, $to_time = null, $include_seconds = false)
    {
        $to_time = $to_time? $to_time: time();

        $distance_in_minutes = floor(abs($to_time - $from_time) / 60);
        $distance_in_seconds = floor(abs($to_time - $from_time));

        $string = '';
        $parameters = array();

        if ($distance_in_minutes <= 1)
        {
            if (!$include_seconds)
            {
                $string = $distance_in_minutes == 0 ? 'less than a minute' : '1 minute';
            }
            else
            {
                if ($distance_in_seconds <= 5)
                {
                    $string = 'less than 5 seconds';
                }
                else if ($distance_in_seconds >= 6 && $distance_in_seconds <= 10)
                {
                    $string = 'less than 10 seconds';
                }
                else if ($distance_in_seconds >= 11 && $distance_in_seconds <= 20)
                {
                    $string = 'less than 20 seconds';
                }
                else if ($distance_in_seconds >= 21 && $distance_in_seconds <= 40)
                {
                    $string = 'half a minute';
                }
                else if ($distance_in_seconds >= 41 && $distance_in_seconds <= 59)
                {
                    $string = 'less than a minute';
                }
                else
                {
                    $string = '1 minute';
                }
            }
        }
        else if ($distance_in_minutes >= 2 && $distance_in_minutes <= 44)
        {
            $string = '%minutes% minutes';
            $parameters['%minutes%'] = $distance_in_minutes;
        }
        else if ($distance_in_minutes >= 45 && $distance_in_minutes <= 89)
        {
            $string = 'about 1 hour';
        }
        else if ($distance_in_minutes >= 90 && $distance_in_minutes <= 1439)
        {
            $string = 'about %hours% hours';
            $parameters['%hours%'] = round($distance_in_minutes / 60);
        }
        else if ($distance_in_minutes >= 1440 && $distance_in_minutes <= 2879)
        {
            $string = '1 day';
        }
        else if ($distance_in_minutes >= 2880 && $distance_in_minutes <= 43199)
        {
            $string = '%days% days';
            $parameters['%days%'] = round($distance_in_minutes / 1440);
        }
        else if ($distance_in_minutes >= 43200 && $distance_in_minutes <= 86399)
        {
            $string = 'about 1 month';
        }
        else if ($distance_in_minutes >= 86400 && $distance_in_minutes <= 525959)
        {
            $string = '%months% months';
            $parameters['%months%'] = round($distance_in_minutes / 43200);
        }
        else if ($distance_in_minutes >= 525960 && $distance_in_minutes <= 1051919)
        {
            $string = 'about 1 year';
        }
        else
        {
            $string = 'over %years% years';
            $parameters['%years%'] = floor($distance_in_minutes / 525960);
        }

        return strtr($string, $parameters);
    }

    public static function timeAgoInWords($from_time, $include_seconds = false)
    {
        return self::distanceOfTimeInWords($from_time, time(), $include_seconds);
    }
}
