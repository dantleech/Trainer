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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SessionController extends Controller
{
    public function indexAction()
    {
        $sessions = $this->get('doctrine.odm.mongodb.document_manager')
            ->createQuery("SELECT s FROM DTLTrainerBundle:Session s ORDER BY s.date DESC")
            ->getResult();

        return $this->render('DTLTrainerBundle:Session:index.html.twig', array(
            'sessions' => $sessions
        ));
    }
}

