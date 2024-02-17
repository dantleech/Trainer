<?php

namespace DTL\TrainerBundle\Repository;
use DTL\TrainerBundle\Util\DocumentUtil;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class SessionRepository extends DocumentRepository
{
    public function fetchRankedSessions($activities, $labels = array())
    {
        $qb = $this->createQueryBuilder();

        if ($labels) {
            $qb->field('labels')->in($labels);
        }

        if ($activities) {
            $ids = array();
            foreach ($activities as $activity) {
                $ids[] = new \MongoId($activity);
            }
            $qb->field('activity.$id')->in($ids);
        }

        $sessions = $qb->getQuery()->execute()->toArray();
        DocumentUtil::rankSessions($sessions);
        $sessions = DocumentUtil::sortDocuments($sessions, 'getDateInSeconds');
        $sessions = array_reverse($sessions);

        return $sessions;
    }

    public function fetchForDateRange(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('date')->gte($startDate);
        $qb->field('date')->lte($endDate);
        $sessions = $qb->getQuery()->execute()->toArray();

        return $sessions;
    }
}
