<?php

namespace DTL\TrainerBundle\Calendar;

class Week extends CalendarUnit
{
    protected $days;

    public function init()
    {
        $currentDayDate = $this->date;
        $days = array();

        for ($i = 0; $i < 7; $i++) {
            $day = new Day($this->calendar, $currentDayDate);
            $days[] = $day;
            $currentDayDate = clone $currentDayDate->modify('+1 day');
        }

        $this->days = $days;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getDom()
    {
        $dom = new \DOMDocument("1.0");
        $weekEl = $dom->createElement('Week');
        $dom->appendChild($weekEl);
        foreach ($this->getDays() as $day) {
            $dayEl = $dom->importNode($day->getDOM()->firstChild, true);
            $weekEl->appendChild($dayEl);
        }
        return $dom;
    }
}
