<?php

namespace DTL\TrainerBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use DTL\TrainerBundle\Document\Route;
use DTL\TrainerBundle\Document\Session;

class ImportLegacyCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputArgument('xml', InputArgument::REQUIRED, 'XML file for legacy trainer data'),
            ))
            ->setName('trainer:import-legacy')
        ;
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When the target directory does not exist
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('xml');
        $dom = new \DOMDocument('1.0');
        $dom->load($file);
        $dm = $this->container->get('doctrine.odm.mongodb.default_document_manager');
        $activity = $dm->getRepository('DTLTrainerBundle:Activity')->findOneByTitle('Run');

        foreach ($dom->firstChild->childNodes as $domTime) {
            $route = $dm->getRepository('DTLTrainerBundle:Route')->findOneBy(array('title' => $domTime->getAttribute('route_name')));
            if (!$route) {
                $route = new Route;
                $route->setTitle($domTime->getAttribute('route_name'));
                $route->setMeasuredBy('distance');
                $route->setDistance($domTime->getAttribute('distance') * 1.609344 * 1000);
                $route->setActivity($activity);
                $route->setLabels(array($domTime->getAttribute('region')));
                $dm->persist($route);
                $dm->flush();
            }

            $session = $route->createSession();
            $session->setRoute($route);
            $session->setTime($domTime->getAttribute('milliseconds') / 1000);
            $session->setLog($domTime->getAttribute('notes'));
            $session->setDate(strtotime($domTime->getAttribute('date')));
            $dm->persist($session);
            $dm->flush();
        }

    }
}

