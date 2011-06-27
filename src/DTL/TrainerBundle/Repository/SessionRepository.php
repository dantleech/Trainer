<?php

namespace DTL\TrainerBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use DTL\TrainerBundle\Util\DocumentUtil;

class SessionRepository extends DocumentRepository
{
    public function fetchRankedSessions($activities)
    {
        $qb = $this->createQueryBuilder();
        if ($activities) {
            $qb->field('activity.title')->in($activities);
        }
        $sessions = $qb->getQuery()->execute()->toArray();
        DocumentUtil::rankSessions($sessions);
        $sessions = DocumentUtil::sortDocuments($sessions, 'getDateInSeconds');
        $sessions = array_reverse($sessions);

        return $sessions;
    }
}
