<?php

use DTL\TrainerBundle\Calendar\Month;
use DTL\TrainerBundle\Calendar\Calendar;

class MonthTest extends \PHPUnit_Framework_TestCase
{
    public function testStart()
    {
        $date = new \DateTime('1st January 2011');
        $month = new Month(new Calendar(new \DateTime), $date);
        $this->assertEquals('26 Dec 10', $month->getStart()->format('d M y'));
    }

    public function testGetWeeks()
    {
        $date = new \DateTime('1st January 2011');
        $month = new Month(new Calendar(new \DateTime), $date);
        $weeks = $month->getWeeks();
    }
}
