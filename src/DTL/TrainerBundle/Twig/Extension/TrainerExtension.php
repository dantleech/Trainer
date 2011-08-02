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

    public function getFunctions()
    {
        return array(
            'format_seconds' => new \Twig_Function_Method($this, 'formatSeconds'),
            'format_meters' => new \Twig_Function_Method($this, 'formatMeters'),
            'format_measure' => new \Twig_Function_Method($this, 'formatMeasure'),
            'time_ago_in_words' => new \Twig_Function_Method($this, 'timeAgoInWords'),
            'format_average_pace' => new \Twig_Function_Method($this, 'formatAveragePace'),
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

    public function formatMeters($meters, $for = 'distance')
    {
        $km = $meters / 1000;
        $formatted = number_format($km, 2);

        return $formatted;
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
        $avg = MathUtil::average($time, $distance / 1000);
        return $this->formatSeconds($avg);
    }

    public function getName()
    {
        return "trainer";
    }
}

