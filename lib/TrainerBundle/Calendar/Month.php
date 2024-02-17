<?php

namespace DTL\TrainerBundle\Calendar;

class Month extends CalendarUnit
{
    protected $calStartDate;
    protected $calEndDate;

    public function init()
    {
        $this->calStartDate = clone $this->date;
        $this->calStartDate
            ->modify('first day of this month')
            ->modify('last sunday');
        $this->calEndDate = clone $this->date;
        $this->calEndDate
            ->modify('last day of this month')
            ->modify('next saturday');

        $this->endDate = clone $this->date;
        $this->endDate->modify('last day of this month');
        $this->startDate = clone $this->date;
        $this->startDate->modify('first day of this month');
    }

    public function getCalStartDate()
    {
        return $this->calStartDate;
    }

    public function getCalEndDate()
    {
        return $this->calEndDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getWeeks()
    {
        $currentWeekDate = clone $this->calStartDate;
        $weeks = array();

        for ($i = 0; $i < 5; $i ++) {
            $week = new Week($this->calendar, clone $currentWeekDate);
            $weeks[] = $week;
            $currentWeekDate = clone $currentWeekDate->modify('+1 week');
        }

        return $weeks;
    }

    public function getDOM()
    {
        $dom = new \DOMDocument("1.0");
        $monthEl = $dom->createElement('Month');
        $dom->appendChild($monthEl);
        foreach ($this->getWeeks() as $i => $week) {
            $weekEl = $dom->importNode($week->getDom()->firstChild, true);
            $monthEl->appendChild($weekEl);
        }

        return $dom;
    }
}
