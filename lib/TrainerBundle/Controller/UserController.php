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
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function preferencesAction(Request $request)
    {
        if ($delete = $request->get('delete')) {
            $this->getPreferences()->remove(key($delete));
            $this->getPreferences()->burn();
            $this->notifySuccess(sprintf('Config key "%s" removed.', key($delete)));
            return $this->redirect($this->generateUrl('preferences'));
        }

        if ($update = $request->get('update')) {
            $key = $request->get('key');
            $value = $request->get('value');
            $this->getPreferences()->set($key, $value);
            $this->getPreferences()->burn();
            $this->notifySuccess(sprintf('Config key "%s" updated.', $key));
            return $this->redirect($this->generateUrl('preferences'));
        }

        return $this->render('DTLTrainerBundle:User:preferences.html.twig', array(
            'preferences' => $this->getPreferences(),
        ));
    }
}

