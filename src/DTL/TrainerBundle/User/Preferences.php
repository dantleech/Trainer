<?php

namespace DTL\TrainerBundle\User;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ODM\MongoDB\DocumentManager;

class Preferences
{
    protected $securityContext;
    protected $dm;

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

        if ($v === null) {
            return $default;
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
