<?php

namespace DTL\TrainerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use DTL\TrainerBundle\Document\LabelableInterface;
use DTL\TrainerBundle\Util\MathUtil;

/**
 * @MongoDB\Document(repositoryClass="DTL\TrainerBundle\Repository\SessionRepository")
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
     * @MongoDB\ReferenceOne(targetDocument="DTL\TrainerBundle\Document\Route", inversedBy="sessions", nullable=true)
     */
    protected $route;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $date;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $log;

    /**
     * @MongoDB\Field(type="integer")
     */
    protected $time;

    /**
     * @MongoDB\Field(type="integer")
     */
    protected $distance;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $distanceIsEstimate;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $weight;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $labels;

    protected $rank;

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
    public function setRoute(\DTL\TrainerBundle\Document\Route $route = null)
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

    public function getDateInSeconds()
    {
        return $this->date->format('U');
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

    public function setLabels(array $labels = array())
    {
        $this->labels = $labels;
    }

    public function getLabels()
    {
        return $this->labels;
    }

    public function getAveragePace()
    {
        $avg = MathUtil::average($this->getTime(), $this->getDistance() / 1000);
        return $avg;
    }

    public function getAverageSpeed()
    {
        $avg = MathUtil::average($this->getDistance(), $this->getTime() / 3600);
        return $avg;
    }

    public function setRank($i)
    {
        $this->rank = $i;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getPerformanceIndicator()
    {
        return MathUtil::average($this->getDistance(), $this->getTime()) * 1000;
    }

    public function getDistanceIsEstimate()
    {
        return $this->distanceIsEstimate;
    }

    public function setDistanceIsEstimate($boolean)
    {
        $this->distanceIsEstimate = $boolean;
    }

    public function getWeight() 
    {
        return $this->weight;
    }
    
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
