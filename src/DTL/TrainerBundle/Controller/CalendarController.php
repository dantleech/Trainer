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

class CalendarController extends Controller
{
    public function indexAction()
    {
        if ($date = $this->get('request')->get('date')) {
            $date = new \DateTime($date);
        } else {
            $date = new \DateTime;
        }

        $calendar = new Calendar($date);
        $month = $calendar->getCurrentMonth();
        $sessions = $this->getRepo('DTLTrainerBundle:Session')
            ->fetchForDateRange(
                $month->getCalStartDate(), 
                $month->getCalEndDate()
            );

        $calendar->addEvents($sessions);
        return $this->render('DTLTrainerBundle:Calendar:index.html.twig', array(
            'calendar' => $calendar,
        ));
    }
}


