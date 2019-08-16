<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * IncidentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncidentRepository extends EntityRepository
{

    /**
     * @param array $parameters
     * @return array|Incident[]
     */
    public function findNotificables($parameters = []): array
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.id = :id')
            ->setParameter('id', 135592);

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $type
     * @param string $address
     * @return array
     */
    public function findByTypeAndAddress(string $type, string $address): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb = $this->queryByAddress($address, $qb);
        $qb = $this->queryByType($type, $qb);

        return $qb->getQuery()->getResult();

    }

    /**
     * @param string $address
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryByAddress(string $address, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);
        $qb->innerJoin('i.origin', 'h')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('h.ip', ':address'),
                $qb->expr()->eq('h.domain', ':address')
            ))
            ->setParameter('address', $address);

        return $qb;

    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('i');
    }

    /**
     * @param string $type
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryByType(string $type, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);
        $qb->andWhere('i.type = :type')
            ->setParameter('type', $type);

        return $qb;

    }

    /**
     * @return array |Incident[]
     */
    public function findAllUnsolved(): array
    {
        return $this->queryAllUnsolved()->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function queryAllUnsolved(): QueryBuilder
    {
        return $this->queryAllOnTreatment()
            ->andWhere('i.unsolvedState != :undefined_state')
            ->andWhere('i.unsolvedState != i.state')
            ->andWhere('i.solveDeadLine <=  CURRENT_TIMESTAMP()')
            ->setParameter('undefined_state', 'undefined');
    }

    public function queryAllOnTreatment(): QueryBuilder
    {
        return $this->queryAllByBehavior(['on_treatment']);
    }

    public function queryAllByBehavior(array $behavior, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);
        $qb->select('i')
            ->innerJoin('i.state', 'state')
            ->andWhere($qb->expr()->in('state.incident_state_behavior', $behavior));
        return $qb;

    }

    /**
     * @param array $criteria
     * @return Incident
     * @throws NonUniqueResultException
     */
    public function findOneLiveBy(array $criteria): Incident
    {
        $qb = $this->queryAllLive();

        $this->addWhereCriteria($criteria, $qb);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return QueryBuilder
     */
    public function queryAllLive(): QueryBuilder
    {
        return $this->queryAllByBehavior(['on_treatment', 'new']);
    }

    public function addWhereCriteria(array $criteria, QueryBuilder $qb)
    {

        foreach ($criteria as $column => $value) {
            $qb->andWhere('i.' . $column . ' = :' . $column)
                ->setParameter($column, $value);
        }

        return $qb;
    }

    /**
     * @param array $criteria
     * @return Incident
     * @throws NonUniqueResultException
     */
    public function findOneDeadBy(array $criteria): Incident
    {
        $qb = $this->queryAllDead();

        $this->addWhereCriteria($criteria, $qb);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function queryAllDead(): QueryBuilder
    {
        return $this->queryAllByBehavior(['closed', 'discarded']);
    }


    public function findAllUnattended()
    {
        return $this->queryAllUnattended()->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function queryAllUnattended(): QueryBuilder
    {
        return $this->queryAllOnTreatment()
            ->andWhere('i.unattendedState != :undefined_state')
            ->andWhere('i.unattendedState != i.state')
            ->andWhere('i.responseDeadLine <=  CURRENT_TIMESTAMP()')
            ->setParameter('undefined_state', 'undefined');
    }

    public function queryAllClosed(): QueryBuilder
    {
        return $this->queryAllByBehavior(['closed']);
    }

    public function queryAllDiscarded(): QueryBuilder
    {
        return $this->queryAllByBehavior(['discarded']);
    }

    public function queryAllNew(): QueryBuilder
    {
        return $this->queryAllByBehavior(['new']);

    }
}
