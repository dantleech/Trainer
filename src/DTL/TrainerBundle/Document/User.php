<?php

namespace DTL\TrainerBundle\Document;
use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /** 
     * @MongoDB\Id(strategy="auto") 
     */
    protected $id;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $preferences = array();

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getPreferences()
    {
        return $this->preferences;
    }

    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
    }

    public function setPreference($field, $value)
    {
        $this->preferences[$field] = $value;
    }

    public function getPreference($field)
    {
        if (isset($this->preferences[$field])) {
            return $this->preferences[$field];
        }

        return null;
    }
}


