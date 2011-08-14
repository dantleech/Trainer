<?php

namespace DTL\TrainerBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use DTL\TrainerBundle\Util\DocumentUtil;

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
}
