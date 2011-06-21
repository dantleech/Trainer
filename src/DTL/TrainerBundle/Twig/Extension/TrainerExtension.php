<?php

namespace DTL\TrainerBundle\Twig\Extension;
use DTL\TrainerBundle\Util\FormatUtil;

class TrainerExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'format_seconds' => new \Twig_Function_Method($this, 'formatSeconds'),
            'format_meters' => new \Twig_Function_Method($this, 'formatMeters'),
        );
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
        $km = $meters / 1000;
        $formatted = number_format($km, 2);
        $formatted .= 'km';
        return $formatted;
    }

    public function getName()
    {
        return "trainer";
    }
}

