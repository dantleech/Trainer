<?php

namespace DTL\TrainerBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use DTL\TrainerBundle\Util\DocumentUtil;

class WeightRepository extends DocumentRepository
{
    public function fetchAllOrdered()
    {
        $qb = $this->createQueryBuilder()
            ->sort('date', 'desc');
        $q = $qb->getQuery();
        $weights = $q->execute();
        return $weights;
    }

    public function getPlotsForPeriod($period = '3 months')
    {
        $dt = new \DateTime();
        $dt->modify('-'.$period);
        $qb = $this->createQueryBuilder()
            ->field('date')->gt($dt)
            ->sort('date', 'desc');
        $weights = $qb->getQuery()->execute();
        $plots = array();
        foreach ($weights as $weight) {
            $plots[] = array($weight->getDate()->format('U') * 1000, $weight->getWeight());
        }
        return $plots;
    }
}
