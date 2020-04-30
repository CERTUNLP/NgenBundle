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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incident::class);
    }

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
     * @return Incident
     * @throws NonUniqueResultException
     */
    public function findOneByTypeAndAddress(string $type, $address = null): ?Incident
    {
        $qb = $this->queryAllLive();
        $qb = $this->queryByType($type, $qb);
        $qb = $this->queryByAddress($address, $qb);

        return $qb->getQuery()->getOneOrNullResult();

    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryAllLive(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['on_treatment', 'new'], $qb);
    }

    public function queryAllByBehavior(array $behavior, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);
        $qb->select('i')
            ->innerJoin('i.state', 'state')
            ->andWhere($qb->expr()->in('state.behavior', $behavior));
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
        $qb->innerJoin('i.type', 't')
            ->andWhere('t.slug = :type')
            ->setParameter('type', $type);

        return $qb;

    }

    /**
     * @param string $address
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryByAddress(string $address = null, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);
        if ($address) {

            $qb->innerJoin('i.origin', 'h')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('h.ip', ':address'),
                    $qb->expr()->eq('h.domain', ':address')
                ))
                ->setParameter('address', $address);
        } else {
            $qb->andWhere(
                $qb->expr()->isNull('i.origin')
            );
        }
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

    public function queryAllOnTreatment(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['on_treatment'], $qb);
    }

    /**
     * @param array $criteria
     * @return Incident
     * @throws NonUniqueResultException
     */
    public function findOneLiveBy(array $criteria): ?Incident
    {
        $qb = $this->queryAllLive();

        $this->addWhereCriteria($criteria, $qb);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function addWhereCriteria(array $criteria, QueryBuilder $qb): QueryBuilder
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

    public function queryAllDead(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['closed', 'discarded'], $qb);
    }


    public function findAllUnattended(): array
    {
        return $this->queryAllUnattended()->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function queryAllUnattended(): QueryBuilder
    {
        return $this->queryAllNew()
            ->andWhere('i.unattendedState != :undefined_state')
            ->andWhere('i.unattendedState != i.state')
            ->andWhere('i.responseDeadLine <=  CURRENT_TIMESTAMP()')
            ->setParameter('undefined_state', 'undefined');
    }

    public function queryAllNew(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['new'], $qb);

    }

    public function queryAllClosed(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['closed'], $qb);
    }

    public function queryAllDiscarded(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->queryAllByBehavior(['discarded'], $qb);
    }
}
