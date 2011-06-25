<?php

namespace DTL\TrainerBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use DTL\TrainerBundle\Controller\Controller;
use DTL\TrainerBundle\Document\Route;
use DTL\TrainerBundle\Form\RouteType;

class FilterController extends Controller
{
    public function sidebarAction()
    {
        $qb = $this->getDm()->createQueryBuilder('DTLTrainerBundle:Session');

        $qb->map('function() {
            if (!this.labels) {
                return;
            }

            for (index in this.labels) {
                emit(this.labels[index], 1);
            }
        }')->reduce('function(previous, current) {
            var count = 0;

            for (index in current) {
                count += current[index];
            }

            return count;
        }');

    $labels = $qb->getQuery()->execute();

        $activities = $this->getDm()
            ->createQueryBuilder('DTLTrainerBundle:Activity')
            ->sort('title', 'asc')
            ->getQuery()
            ->execute();

        $activeActivities = $this->getActiveFilters('activity');
        $activeLabels = $this->getActiveFilters('label');

        return $this->render('DTLTrainerBundle:Filter:sidebar.html.twig', array(
            'labels' => $labels,
            'activities' => $activities,
            'activeActivities' => $activeActivities,
            'activeLabels' => $activeLabels,
        ));
    }

    public function updateAction()
    {
        $type = $this->get('request')->get('type');
        $id = $this->get('request')->get('id');
        $this->filterToggle($type, $id);

        return new Response();
    }
}
