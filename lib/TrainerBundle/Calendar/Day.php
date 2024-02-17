<?php

namespace DTL\TrainerBundle\Calendar;

class Day extends CalendarUnit
{
    public function getEvents()
    {
        return $this->calendar->getEventsForDate($this->getDate());
    }

    public function isInMonth()
    {
        if ($this->getDate()->format('m') == $this->calendar->getDate()->format('m')) {
            return true;
        }

        return false;
    }

    public function getDOM()
    {
        $dom = new \DOMDocument("1.0");
        $dayEl = $dom->createElement('Day');
        $dom->appendChild($dayEl);
        foreach ($this->getEvents() as $event) {
            $eventEl = $dom->createElement('Event');
            $eventEl->setAttribute('distance', $event->getDistance());
            $eventEl->setAttribute('time', $event->getTime());
            $eventEl->setAttribute('activity', $event->getActivity());
            $dayEl->appendChild($eventEl);
        }
        return $dom;
    }
}
