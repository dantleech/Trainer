<?php

namespace DTL\TrainerBundle\Twig\Extension;
use DTL\TrainerBundle\Util\FormatUtil;
use DTL\TrainerBundle\Util\MathUtil;
use DTL\TrainerBundle\Services\DistanceFormatter;
use FOS\UserBundle\Model\UserManager;
use DTL\TrainerBundle\User\Preferences;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TrainerExtension extends AbstractExtension
{
    protected $preferences;

    public function __construct(Preferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public function initRuntime(Environment $env)
    {
        $env->addGlobal('user_preference', $this->preferences);
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('format_seconds', [$this, 'formatSeconds']),
            new TwigFunction('format_meters', [$this, 'formatMeters']),
            new TwigFunction('format_measure', [$this, 'formatMeasure']),
            new TwigFunction('time_ago_in_words', [$this, 'timeAgoInWords']),
            new TwigFunction('format_average_pace', [$this, 'formatAveragePace']),
            new TwigFunction('format_average_speed', [$this, 'formatAverageSpeed']),
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

    public function formatMeters($meters, $unit = null)
    {
        if (!$unit) {
            $unit = $this->preferences->get('distanceUnit');
        }

        $distance = FormatUtil::metersToDistance($meters, $unit);
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

    public function twigTruncateFilter(\Twig_Environment $env, $value, $length = 30, $preserve = false, $separator = '...')
    {
die('asd');
        if (strlen($value) > $length) {
            if ($preserve) {
                if (false !== ($breakpoint = strpos($value, ' ', $length))) {
                    $length = $breakpoint;
                }
            }

            return substr($value, 0, $length) . $separator;
        }

        return $value;
    }


    public function getName()
    {
        return "trainer";
    }
}


