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
use Symfony\Component\HttpFoundation\Request;

class SessionController extends Controller
{
    protected function getSession()
    {
        return $this->getDocumentFromRequest('DTLTrainerBundle:Session', 'session_id');
    }

    public function indexAction(Request $request)
    {
        $rep = $this->getDm()->getRepository('DTLTrainerBundle:Session');
        $sessions = $rep->fetchRankedSessions($this->getActiveFilters('activity'), $this->getActiveFilters('label_session'));
        $format = $request->query->get('_format') ?: 'html';

        return $this->render('@DTLTrainer/Session/index.'.$format.'.twig', array(
            'sessions' => $sessions
        ));
    }

    public function newAction()
    {
        $session = new Session();
        return $this->processPage($session);
    }

    public function editAction()
    {
        $session = $this->getSession();
        return $this->processPage($session);
    }

    public function viewAction()
    {
        $session = $this->getSession();
        return $this->render('DTLTrainerBundle:Session:view.html.twig', array(
            'session' => $session,
        ));
    }

    public function deleteAction()
    {
        $session = $this->getSession();
        $this->getDm()->remove($session);
        $this->getDm()->flush();
        $this->notifySuccess('Session Deleted');
        return $this->redirect($this->generateUrl('sessions'));
    }

    protected function processPage($session)
    {
        $routes = $this->get('doctrine.odm.mongodb.document_manager')
            ->createQueryBuilder('DTLTrainerBundle:Route')
            ->getQuery()
            ->toArray();

        $form = $this->createForm(new SessionType(), $session);
        $message = $session->getId() ? 'Session Updated' : 'Session Created';
        $template = $session->getId() ? 'edit' : 'new';

        if ($this->processForm($form)) {
            $this->notifySuccess($message);
            return $this->redirect($this->generateUrl('session_view', array('session_id' => $session->getId())));
        }

        return $this->render('DTLTrainerBundle:Session:'.$template.'.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
            'routes' => $routes,
        ));
    }
}
