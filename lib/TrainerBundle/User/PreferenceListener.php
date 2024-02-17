<?php

namespace DTL\TrainerBundle\User;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use DTL\TrainerBundle\User\Preferences;

class PreferenceListener
{
    protected $preferences;

    public function __construct(Preferences $preferences)
    {
        $this->preferences = $preferences;
    }

    public function registerPreferences(GetResponseEvent $event)
    {
        if ($event->getRequest()->query->has('_preferences')) {
            $prefs = $event->getRequest()->query->get('_preferences');
            foreach ($prefs as $key => $value) {
                $this->preferences->set($key, $value);
            }
            $this->preferences->burn();
        }
    }
}
