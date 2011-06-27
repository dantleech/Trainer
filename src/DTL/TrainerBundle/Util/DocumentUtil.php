<?php

namespace DTL\TrainerBundle\Util;

class DocumentUtil
{
    public static function rankSessions($sessions)
    {
        $sessions = self::sortDocuments($sessions, 'getAveragePace');
        foreach ($sessions as $i => $session) {
            $session->setRank($i + 1);
        }
    }

    public static function sortDocuments($documents, $accessor)
    {
        usort($documents, function ($a, $b) use ($accessor) {
            $at = $a->$accessor();
            $bt = $b->$accessor();
            if ($at == $bt) {
                return 0;
            }

            return $at < $bt ? -1 : 1;
        });
        return $documents;
    }
}
