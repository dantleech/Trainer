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
        $veloHip->setLabels(array('paris'));
        $manager->persist($veloHip);

        $runTour = new Route();
        $runTour->setTitle('Arc / Eiffel / Champs / Wagram');
        $runTour->setActivity($run);
        $runTour->setDistance('12500');
        $runTour->setLabels(array('paris'));
        $manager->persist($runTour);

        $swimParm = new Route();
        $swimParm->setTitle('Piscine Parmantier 1km');
        $swimParm->setActivity($swim);
        $swimParm->setDistance('1000');
        $swimParm->setLabels(array('paris', 'ylly'));
        $manager->persist($swimParm);

        $sess1 = new Session();
        $sess1->setRoute($runTour);
        $sess1->setTime(35123);
        $sess1->setLog('This is a test run');
        $sess1->setLabels(array('paris', 'exploring'));
        $sess1->setDate(new \DateTime());
        $manager->persist($sess1);

        $sess2 = new Session();
        $sess2->setRoute($veloHip);
        $sess2->setDistance(37000);
        $sess2->setLog('This is a test bike ride');
        $sess2->setDate(new \DateTime());
        $sess2->setLabels(array('paris', 'rekky'));
        $manager->persist($sess2);

        $sess3 = new Session();
        $sess3->setRoute($swimParm);
        $sess3->setTime(1200);
        $sess3->setLog('This is a test swim');
        $sess3->setDate(new \DateTime());
        $manager->persist($sess3);

        $sess4 = new Session();
        $sess4->setActivity($run);
        $sess4->setTime(1200);
        $sess4->setDistance(1000);
        $sess4->setLog('Climbing Mnt Blanc');
        $sess4->setDate(new \DateTime());
        $manager->persist($sess4);

        $manager->flush();
    }
}
