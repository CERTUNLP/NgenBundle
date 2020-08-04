<?php

namespace CertUnlp\NgenBundle\Repository;

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
     * @return IncidentDecision|object| null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?IncidentDecision
    {
        $get_undefined = false;
        $criteria['active'] = true;
        $criteria['network'] = is_object($criteria['network']) ? $criteria['network']->getId() : $criteria['network'];
        if (!$criteria['network']) {
            unset($criteria['network']);
        }
        if (isset($criteria['get_undefined'])) {
            $get_undefined = $criteria['get_undefined'];
            unset($criteria['get_undefined']);
        }
        if ($get_undefined) {
            $decision = null;
            if (isset($criteria['type'], $criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => $criteria['feed'], 'type' => $criteria['type'], 'network' => $criteria['network'] ?? null, 'active' => true), $orderBy);
            }
            if (!$decision && isset($criteria['type']) && !isset($criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => $criteria['type'], 'network' => $criteria['network'] ?? null, 'active' => true), $orderBy);
            }
            if (!$decision && !isset($criteria['type']) && isset($criteria['feed'])) {
                $decision = parent::findOneBy(array('feed' => $criteria['feed'], 'type' => 'undefined', 'network' => $criteria['network'] ?? null, 'active' => true), $orderBy);
            }
            if (!$decision && isset($criteria['network'])) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => 'undefined', 'network' => $criteria['network'], 'active' => true), $orderBy);
            }
            if (!$decision) {
                $decision = parent::findOneBy(array('feed' => 'undefined', 'type' => 'undefined', 'network' => null, 'active' => true), $orderBy);
            }
            return $decision;
        }

        return parent::findOneBy($criteria, $orderBy);
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
        $get_undefined = false;
        $criteria['active'] = true;
        if (isset($criteria['get_undefined'])) {
            $get_undefined = $criteria['get_undefined'];
            unset($criteria['get_undefined']);
        }
        if ($get_undefined) {
            $decision = null;
            if (isset($criteria['type'], $criteria['feed'])) {
                $decision = parent::findBy(array('feed' => $criteria['feed'], 'type' => $criteria['type'], 'active' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && isset($criteria['type']) && !isset($criteria['feed'])) {
                $decision = parent::findBy(array('feed' => 'undefined', 'type' => $criteria['type'], 'active' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && !isset($criteria['type']) && isset($criteria['feed'])) {
                $decision = parent::findBy(array('feed' => $criteria['feed'], 'type' => 'undefined', 'active' => true), $orderBy, $limit, $offset);
            }
            if (!$decision && isset($criteria['network'])) {
                $decision = parent::findBy(array('feed' => 'undefined', 'type' => 'undefined', 'active' => true), $orderBy, $limit, $offset);
            }
            $decision = array_merge($decision, parent::findBy(array('feed' => 'undefined', 'type' => 'undefined', 'active' => true), $orderBy, $limit, $offset));
            return $decision;
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
