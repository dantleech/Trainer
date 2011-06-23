<?php

namespace DTL\TrainerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Session
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="DTL\TrainerBundle\Document\Activity")
     */
    protected $activity;

    /**
     * @MongoDB\ReferenceOne(targetDocument="DTL\TrainerBundle\Document\Route")
     */
    protected $route;

    /**
     * @MongoDB\Date
     */
    protected $date;

    /**
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\String
     */
    protected $log;

    /**
     * @MongoDB\Int
     */
    protected $time;

    /**
     * @MongoDB\Int
     */
    protected $distance;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set activity
     *
     * @param DTL\TrainerBundle\Document\Activity $activity
     */
    public function setActivity(\DTL\TrainerBundle\Document\Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get activity
     *
     * @return DTL\TrainerBundle\Document\Activity $activity
     */
    public function getActivity()
    {
        if ($this->route) {
            return $this->route->getActivity();
        }

        return $this->activity;
    }

    /**
     * Set route
     *
     * @param DTL\TrainerBundle\Document\Route $route
     */
    public function setRoute(\DTL\TrainerBundle\Document\Route $route)
    {
        $this->route = $route;
    }

    /**
     * Get route
     *
     * @return DTL\TrainerBundle\Document\Route $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        if ($this->route) {
            return $this->route->getTitle();
        }
        return $this->title;
    }

    /**
     * Set log
     *
     * @param string $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * Get log
     *
     * @return string $log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set time
     *
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return int $time
     */
    public function getTime()
    {
        if ($this->route) {
            if ($this->route->isMeasuredBy('time')) {
                return $this->route->getTime();
            }
        }

        return $this->time;
    }

    /**
     * Set distance
     *
     * @param int $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * Get distance
     *
     * @return int $distance
     */
    public function getDistance()
    {
        if ($this->route) {
            if ($this->route->isMeasuredBy('distance')) {
                return $this->route->getDistance();
            }
        }

        return $this->distance;
    }
}
