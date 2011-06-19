<?php

namespace DTL\TrainerBiundle\DataFixtures\ODM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use DTL\TrainerBundle\Document\Route;
use DTL\TrainerBundle\Document\Activity;
use DTL\TrainerBundle\Document\Session;

class LoadData implements FixtureInterface
{
    public function load($manager)
    {
        $run = new Activity();
        $run->setTitle('Run');
        $run->setIcon('run.png');
        $manager->persist($run);

        $swim = new Activity();
        $swim->setTitle('Swim');
        $swim->setIcon('swim.png');
        $manager->persist($swim);

        $velo = new Activity();
        $velo->setTitle('Velo');
        $velo->setIcon('velo.png');
        $manager->persist($velo);

        $veloHip = new Route();
        $veloHip->setTitle('Boulogne Hippodrome');
        $veloHip->setActivity($velo);
        $veloHip->setTime('3600');
        $veloHip->setMeasuredBy('time');
        $manager->persist($veloHip);

        $runTour = new Route();
        $runTour->setTitle('Arc / Eiffel / Champs / Wagram');
        $runTour->setActivity($run);
        $runTour->setDistance('12500');
        $manager->persist($runTour);

        $swimParm = new Route();
        $swimParm->setTitle('Piscine Parmantier 1km');
        $swimParm->setActivity($swim);
        $swimParm->setDistance('1000');
        $manager->persist($swimParm);

        $sess1 = new Session();
        $sess1->setRoute($runTour);
        $sess1->setTime(35123);
        $sess1->setLog('This is a test run');
        $sess1->setDate(new \DateTime());
        $manager->persist($sess1);

        $sess2 = new Session();
        $sess2->setRoute($veloHip);
        $sess2->setDistance(37000);
        $sess2->setLog('This is a test bike ride');
        $sess2->setDate(new \DateTime());
        $manager->persist($sess2);

        $sess3 = new Session();
        $sess3->setRoute($swimParm);
        $sess3->setTime(1200);
        $sess3->setLog('This is a test swim');
        $sess3->setDate(new \DateTime());
        $manager->persist($sess3);

        $manager->flush();
    }
}
