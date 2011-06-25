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
use DTL\TrainerBundle\Document\Route;
use DTL\TrainerBundle\Form\RouteType;

class RouteController extends Controller
{
    protected function getRoute()
    {
        return $this->getDocumentFromRequest('DTLTrainerBundle:Route', 'route_id');
    }

    public function indexAction()
    {
        $routes = $this->getDm()
            ->createQueryBuilder('DTLTrainerBundle:Route')
            ->sort('title', 'asc')
            ->getQuery()
            ->execute();

        return $this->render('DTLTrainerBundle:Route:index.html.twig', array(
            'routes' => $routes
        ));
    }

    public function newAction()
    {
        $route = new Route();
        $form = $this->createForm(new RouteType(), $route);

        if ($this->processForm($form)) {
            $this->notifySuccess('Route Added');
            $this->redirect($this->generateUrl('route_new'));
        }

        return $this->render('DTLTrainerBundle:Route:new.html.twig', array(
            'form' => $form->createView(),
            'route' => $route,
        ));
    }

    public function editAction()
    {
        $route = $this->getRoute();
        $form = $this->createForm(new RouteType(), $route);

        if ($this->processForm($form)) {
            $this->notifySuccess('Route Updated');
            $this->redirect($this->generateUrl('route_edit', array('route_id' => $route->getId())));
        }

        return $this->render('DTLTrainerBundle:Route:new.html.twig', array(
            'form' => $form->createView(),
            'route' => $route,
        ));
    }

    public function viewAction()
    {
        $route = $this->getRoute();
        return $this->render('DTLTrainerBundle:Route:view.html.twig', array('route' => $route));
    }
}

