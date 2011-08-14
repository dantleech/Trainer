<?php

namespace DTL\TrainerBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use DTL\TrainerBundle\Controller\Controller;
use DTL\TrainerBundle\Document\Route;
use DTL\TrainerBundle\Form\RouteType;

class FilterController extends Controller
{
    public function sidebarAction($type = 'session')
    {
        if ($type == 'session') {
            $qb = $this->getDm()->createQueryBuilder('DTLTrainerBundle:Session');
        } elseif ($type == 'route') {
            $qb = $this->getDm()->createQueryBuilder('DTLTrainerBundle:Route');
        }

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
        $activeLabels = $this->getActiveFilters('label_'.$type);

        return $this->render('DTLTrainerBundle:Filter:sidebar.html.twig', array(
            'labels' => $labels,
            'activities' => $activities,
            'activeActivities' => $activeActivities,
            'activeLabels' => $activeLabels,
            'context' => $type,
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
