<?php

namespace DTL\TrainerBundle\Calendar;

abstract class CalendarUnit
{
    protected $calendar;
    protected $date;
    protected $eventRepo;
    protected $events;

    public function __construct(Calendar $calendar, $date)
    {
        $this->calendar = $calendar;
        $this->date = $date;
        $this->init();
    }

    public function init()
    {
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getXPath()
    {
        return new \DOMXPath($this->getDOM());
    }

    public function getActivities()
    {
        $activities = array();
        $events = $this->getXPath()->query('//Event');
        foreach ($events as $event) {
            $activities[$event->getAttribute('activity')] = $event->getAttribute('activity');
        }

        return array_values($activities);
    }
}
