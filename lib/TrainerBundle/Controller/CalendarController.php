<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\TrainerBundle\Controller;

use DTL\TrainerBundle\Controller\Controller;
use DTL\TrainerBundle\Calendar\Calendar;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    public function indexAction()
    {
        if ($date = $this->getRequest()->get('date')) {
            $date = new \DateTime($date);
        } else {
            $date = new \DateTime;
        }

        if ($month = $this->getRequest()->get('month')) {
            $date->modify('first day of january');
            $date->modify(($month - 1).' month');
        }

        $calendar = new Calendar($date);
        $month = $calendar->getCurrentMonth();
        $sessions = $this->getRepo('DTLTrainerBundle:Session')
            ->fetchForDateRange(
                $month->getCalStartDate(), 
                $month->getCalEndDate()
            );
        $calendar->addEvents($sessions);

        $format = $this->getRequest()->getRequestFormat();

        if ($format == 'xml') {
            return new Response($month->getDOM()->saveXML()); //rray('Content-Type: text/xml'));
        }

        return $this->render('DTLTrainerBundle:Calendar:index.'.$format.'.twig', array(
            'calendar' => $calendar,
        ));
    }
}


