<?php

namespace DTL\TrainerBundle\Calendar;

class Day extends CalendarUnit
{
    public function getEvents()
    {
        return $this->calendar->getEventsForDate($this->getDate());
    }
}
