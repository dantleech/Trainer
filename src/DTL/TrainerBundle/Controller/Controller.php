<?php

namespace DTL\TrainerBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Form\Form;

class Controller extends BaseController
{
    protected function notify($message, $type)
    {
        $message = $this->get('translator')->trans($message);
        $this->get('session')->setFlash($type, $message);
    }

    protected function notifySuccess($message)
    {
        $this->notify($message, 'success');
    }

    protected function notifyError($message)
    {
        $this->notify($message, 'error');
    }

    protected function getDm()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

    protected function processForm(Form $form)
    {
        $request = $this->get('request');
        $dm = $this->getDm();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $dm->persist($form->getData());
                $dm->flush();
                return true;
            }
        }

        return false;
    }

    protected function getDocumentFromRequest($type, $idParam)
    {
        if (!$id = $this->get('request')->get($idParam)) {
            throw new \Exception('No ID given in request');
        }
        $document = $this->getDm()->find($type, $id);
        return $document;
    }

    public function getActiveFilters($type)
    {
        $filters = $this->getPreferences()->get('filters', array());
        return isset($filters[$type]) ? $filters[$type] : array();
    }

    public function filterToggle($type, $id)
    {
        $filters = $this->getPreferences()->get('filters', array());
        if (!isset($filters[$type][$id])) {
            $filters[$type][$id] = $id;
        } else {
            unset($filters[$type][$id]);
        }

        $this->getPreferences()->set('filters', $filters);
        $this->getPreferences()->burn();
    }

    public function getPreferences()
    {
        return $this->container->get('dtl_trainer.user.preferences');
    }
}
