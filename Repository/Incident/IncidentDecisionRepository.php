<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentDecisionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncidentDecision::class);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|object|null
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        if (isset($criteria['get_undefined'])) {
            $criteria1 = array('type' => $criteria['type'], 'feed' => $criteria['feed'], 'active' => true);
            $criteria2 = array('type' => $criteria['type'], 'feed' => 'undefined', 'active' => true);
            $criteria3 = array('type' => 'undefined', 'feed' => $criteria['feed'], 'active' => true);
            $criteria4 = array('type' => 'undefined', 'feed' => 'undefined', 'active' => true);
            $decision = parent::findBy($criteria1, $orderBy, $limit, $offset);
            $decision = array_merge($decision, parent::findBy($criteria2, $orderBy, $limit, $offset));
            $decision = array_merge($decision, parent::findBy($criteria3, $orderBy, $limit, $offset));
            $decision = array_merge($decision, parent::findBy($criteria4, $orderBy, $limit, $offset));
            return $decision;
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
