<?php

namespace DTL\TrainerBundle\User;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ODM\MongoDB\DocumentManager;

class Preferences
{
    protected $securityContext;
    protected $dm;
    protected $defaults = array(
        'distanceUnit' => 'km'
    );

    public function __construct(SecurityContext $securityContext, DocumentManager $dm) 
    {
        $this->securityContext = $securityContext;
        $this->dm = $dm;
    }

    public function getUser()
    {
        return $this->securityContext->getToken()->getUser();
    }

    public function get($field, $default = null)
    {
        $v = $this->getUser()->getPreference($field);

        if ($v === null && $default) {
            return $default;
        } elseif ($v === null && array_key_exists($field, $this->defaults)) {
            return $this->defaults[$field];
        }

        return $v;
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
