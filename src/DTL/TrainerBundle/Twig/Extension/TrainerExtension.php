<?php

namespace DTL\TrainerBundle\Twig\Extension;
use DTL\TrainerBundle\Util\FormatUtil;
use DTL\TrainerBundle\Util\MathUtil;
use DTL\TrainerBundle\Services\DistanceFormatter;
use FOS\UserBundle\Model\UserManager;
use DTL\TrainerBundle\User\Preferences;

class TrainerExtension extends \Twig_Extension
{
    protected $preferences;

    public function __construct(Preferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public function initRuntime(\Twig_Environment $env)
    {
        $env->addGlobal('user_preference', $this->preferences);
    }


    public function getFunctions()
    {
        return array(
            'format_seconds' => new \Twig_Function_Method($this, 'formatSeconds'),
            'format_meters' => new \Twig_Function_Method($this, 'formatMeters'),
            'format_measure' => new \Twig_Function_Method($this, 'formatMeasure'),
            'time_ago_in_words' => new \Twig_Function_Method($this, 'timeAgoInWords'),
            'format_average_pace' => new \Twig_Function_Method($this, 'formatAveragePace'),
            'format_average_speed' => new \Twig_Function_Method($this, 'formatAverageSpeed'),
        );
    }

    public function timeAgoInWords($fromTime)
    {
        return FormatUtil::timeAgoInWords($fromTime);
    }

    
    public function formatSeconds($seconds, $as = 'stopwatch')
    {
        $validTypes = array('stopwatch');
        if (!in_array($as, $validTypes)) {
            throw new \Exception('Format must be one of '.implode(',', $validTypes));
        }
        return FormatUtil::secondsToStopwatch($seconds);
    }

    public function formatMeters($meters)
    {
        $distance = FormatUtil::metersToDistance($meters, $this->preferences->get('distanceUnit'));
        $distance = number_format($distance, 2);
        return $distance;
    }

    public function formatMeasure($measure, $measuredBy)
    {
        if ($measuredBy == 'time') {
            return $this->formatSeconds($measure);
        } elseif ($measuredBy == 'distance') {
            return $this->formatMeters($measure);
        }
    }

    public function formatAveragePace($time, $distance)
    {
        $avg = MathUtil::average($time, 
            FormatUtil::metersToDistance($distance, $this->preferences->get('distanceUnit'))
        );
        return $this->formatSeconds($avg);
    }

    public function formatAverageSpeed($time, $distance)
    {
        $avg = MathUtil::average(
            FormatUtil::metersToDistance($distance, $this->preferences->get('distanceUnit')),
            $time / 60 / 60
        );
    
        return number_format($avg, 2);
    }


    public function getName()
    {
        return "trainer";
    }
}

