<?php

namespace DTL\TrainerBundle\Calendar;

/**
 * Calendar 
 *
 * @REFACTOR: Store events in DOM
 * 
 * @package 
 * @author Daniel Leech <daniel@dantleech.com> 
 */
class Calendar
{
    protected $date;
    protected $events = array();

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getCurrentMonth()
    {
        $month = new Month($this, $this->date);
        return $month;
    }

    public function addEvents($events)
    {
        foreach ($events as $event) {
            $this->events[$event->getDate()->format('Ymd')][] = $event;
        }
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function getEventsForDate(\DateTime $date)
    {
        $index = $date->format('Ymd');
        if (!isset($this->events[$index])) {
            return array();
        } else {
            return $this->events[$index];
        }
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getCurrentDate()
    {
        return new \DateTime();
    }
}
