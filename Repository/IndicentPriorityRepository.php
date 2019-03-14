<?php

namespace CertUnlp\NgenBundle\Repository;

/**
 * IndicentPriorityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IndicentPriorityRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        if (isset($criteria['urgency'], $criteria['impact'])) {
            return parent::findOneBy(array('urgency' => $criteria['urgency'], 'impact' => $criteria['impact']));
        }
        if (!isset($criteria['urgency'], $criteria['feed'])) {
            return parent::findOneBy(array('feed' => 'undefined', 'type' => 'undefined'));
        }
        return parent::findOneBy($criteria, $orderBy);
    }
}
