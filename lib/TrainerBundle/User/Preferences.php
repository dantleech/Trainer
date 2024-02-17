<?php

namespace DTL\TrainerBundle\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ODM\MongoDB\DocumentManager;

class Preferences
{
    protected $securityContext;
    protected $dm;
    protected $defaults = array(
        'distanceUnit' => 'km',
        'siteTitle' => 'Mongo Trainer',
    );

    public function __construct(TokenStorage $securityContext, DocumentManager $dm) 
    {
        $this->securityContext = $securityContext;
        $this->dm = $dm;
    }

    public function getUser()
    {
        if ($this->securityContext->getToken()) {
            return $this->securityContext->getToken()->getUser();
        }

        return null;
    }

    public function get($field, $default = null)
    {
        if ($user = $this->getUser()) {
            $v = $this->getUser()->getPreference($field);
        } else {
            $v = null;
        }

        if ($v === null && $default) {
            return $default;
        } elseif ($v === null && array_key_exists($field, $this->defaults)) {
            return $this->defaults[$field];
        }

        return $v;
    }

    public function getAll()
    {
        return $this->getUser()->getPreferences();
    }

    public function remove($field)
    {
        $this->getUser()->removePreference($field);
    }

    public function set($field, $value)
    {
        return $this->getUser()->setPreference($field, $value);
    }

    public function burn()
    {
        $this->dm->persist($this->getUser());
        $this->dm->flush();
    }
}
