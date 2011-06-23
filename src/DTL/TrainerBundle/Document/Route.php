<?php

namespace DTL\TrainerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use DTL\TrainerBundle\Validator\Constraints as TrainerAssert;

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
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @MongoDB\ReferenceOne(targetDocument="DTL\TrainerBundle\Document\Activity")
     * @Assert\NotBlank()
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
     * @TrainerAssert\Stopwatch
     */
    protected $time;

    /**
     * @MongoDB\String
     * @Assert\NotBlank
     */
    protected $measuredBy = 'time';

    /**
     * @MongoDB\ReferenceMany(targetDocument="DTL\TrainerBundle\Document\Session", mappedBy="route")
     */
    protected $sessions = array();


    protected static $measuredByChoices = array(
        'time' => 'Time',
        'distance' => 'Distance',
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

    public function isMeasuredBy($by)
    {
        return $this->measuredBy == $by ? true : false;
    }

    public function setMeasuredBy($by)
    {
        if (!in_array($by, array_keys(self::$measuredByChoices))) {
            throw new \InvalidArgumentException(sprintf('Measured by must be one of "%s", "%s" given',
                implode(',', array_keys(self::$measuredByChoices)), $by));

        }

        $this->measuredBy = $by;
    }

    public static function getMeasuredByChoices()
    {
        return self::$measuredByChoices;
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

    public function __toString()
    {
        return (string) $this->title;
    }

    public function getSessionCount()
    {
        return count($this->sessions);
    }

    public function getMeasure($session)
    {
        if ($this->isMeasuredBy('time')) {
            return $session->getDistance();
        } else {
            return $session->getTime();
        }
    }

    public function getBest()
    {
        $best = null;
        foreach ($this->sessions as $session) {
            $measure = $this->getMeasure($session);
            if (!$best) {
                $best = $measure;
            }

            if ($this->isMeasuredBy('distance')) {
                if ($measure < $best) {
                    $best = $measure;
                }
            } else {
                if ($measure > $best) {
                    $best = $measure;
                }
            }
        }

        return $best;
    }

    public function getTrend()
    {
        $trend = array();
        foreach ($this->sessions as $session) {
            $trend[] = $this->getMeasure($session);
        }
        return $trend;
    }
}
