<?php

namespace DTL\TrainerBundle\Util;

class DocumentUtil
{
    public static function rankSessions($sessions)
    {
        $sessions = self::sortDocuments($sessions, 'getAveragePace');
        $zeroTimed = array();

        foreach ($sessions as $i => $session) {
            if (!$sessions[$i]->getTime() || !$sessions[$i]->getDistance()) {
                $session->setRank('999999');
                unset($sessions[$i]);
            } else {
                break;
            }
        }

        $rank = 1;
        foreach ($sessions as $session) {
            $session->setRank($rank);
            $rank++;
        }
    }

    public static function sortDocuments($documents, $accessor, $order = 'asc')
    {
        usort($documents, function ($a, $b) use ($accessor, $order) {
            $at = $a->$accessor();
            $bt = $b->$accessor();
            if ($at == $bt) {
                return 0;
            }

            if ($order == 'asc') {
                return $at < $bt ? -1 : 1;
            } else {
                return $at > $bt ? -1 : 1;
            }
        });
        return $documents;
    }
}
