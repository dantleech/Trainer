<?php

namespace DTL\TrainerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Route
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\ReferenceOne(targetDocument="DTL\TrainerBundle\Document\Activity")
     */
    protected $activity;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\Int
     */
    protected $distance;

    /**
     * @MongoDB\Int
     */
    protected $time;

    /**
     * @MongoDB\String
     */
    protected $measuredBy = 'time';

    protected $measuredByTypes = array(
        'time',
        'distance',
    );

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
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
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
        return $this->distance;
    }

    public function getMeasuredBy()
    {
        return $this->measuredBy;
    }

    public function setMeasuredBy($by)
    {
        if (!in_array($by, $this->measuredByTypes)) {
            throw new \InvalidArgumentException(sprintf('Measured by must be one of "%s", "%s" given',
                implode(',', $this->measuredByTypes), $by));

        }

        $this->measuredBy = $by;
    }

    public function getMeasuredByTypes()
    {
        return $this->measuredByTypes;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getTime()
    {
        return $this->time;
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
        return $this->activity;
    }
}
