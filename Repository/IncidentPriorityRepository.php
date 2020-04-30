<?php

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentPriorityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncidentPriority::class);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?object
    {
        if (isset($criteria['urgency'], $criteria['impact'])) {
            return parent::findOneBy(array('urgency' => $criteria['urgency'], 'impact' => $criteria['impact']));
        }
        if (!isset($criteria['urgency'], $criteria['impact'])) {
            return parent::findOneBy(array('urgency' => 'undefined', 'impact' => 'undefined'));
        }
        return parent::findOneBy($criteria, $orderBy);
    }
}
