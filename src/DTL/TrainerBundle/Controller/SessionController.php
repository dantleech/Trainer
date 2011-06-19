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

use DTL\TrainerBundle\Document\Session;
use DTL\TrainerBundle\Form\SessionType;
use DTL\TrainerBundle\Controller\Controller;

class SessionController extends Controller
{
    protected function getSession()
    {
        return $this->getDocumentFromRequest('DTLTrainerBundle:Session', 'session_id');
    }

    public function indexAction()
    {
        $sessions = $this->get('doctrine.odm.mongodb.document_manager')
            ->createQueryBuilder('DTLTrainerBundle:Session')
            ->sort('date', 'desc')
            ->getQuery()
            ->execute();

        return $this->render('DTLTrainerBundle:Session:index.html.twig', array(
            'sessions' => $sessions
        ));
    }

    public function newAction()
    {
        $session = new Session();
        $form = $this->createForm(new SessionType(), $session);

        return $this->render('DTLTrainerBundle:Session:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction()
    {
        $session = $this->getSession();
        $form = $this->createForm(new SessionType(), $session);

        if ($this->processForm($form)) {
            $this->notifySuccess('Session Updated');
            $this->redirect($this->generateUrl('session_edit', array('session_id' => $session->getId())));
        }

        return $this->render('DTLTrainerBundle:Session:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
