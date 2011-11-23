<?php

namespace DTL\TrainerBundle\Calendar;

class Week extends CalendarUnit
{
    public function getDays()
    {
        $currentDayDate = $this->date;
        $days = array();

        for ($i = 0; $i < 7; $i++) {
            $day = new Day($this->calendar, $currentDayDate);
            $days[] = $day;
            $currentDayDate = clone $currentDayDate->modify('+1 day');
        }

        return $days;
    }
}
