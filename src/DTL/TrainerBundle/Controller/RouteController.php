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

class RouteController extends Controller
{
    public function indexAction()
    {
        $routes = $this->getDoctrine()
            ->createQuery("SELECT r FROM DTLTrainerBundle:Route r ORDER BY r.title ASC")
            ->getResult();

        return $this->render('DTLTrainerBundle:Route:index.html.twig', array(
            'routes' => $routes
        ));
    }
}

