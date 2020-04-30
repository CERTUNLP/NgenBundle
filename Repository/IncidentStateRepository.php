<?php

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentStateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncidentState::class);
    }

    /**
     * @param string $state
     * @return array
     */
    public function findNewStates(string $state): array
    {
        $qb = $this->queryNewStates($state);

        return $qb->getQuery()->getResult();

    }

    /**
     * @param string $state
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryNewStates(string $state, QueryBuilder $qb = null): QueryBuilder
    {
        $qb2 = $this->queryNewStateSlugs($state);
        $slugs = [];
        foreach ($qb2->getQuery()->getResult() as $item) {
            $slugs[] = $item['slug'];
        }
        $qb = $this->getOrCreateQueryBuilder($qb);

        $qb
            ->where($qb->expr()->in('i.slug', $slugs));

        return $qb;

    }

    /**
     * @param string $state
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    public function queryNewStateSlugs(string $state, QueryBuilder $qb = null): QueryBuilder
    {
        $qb = $this->getOrCreateQueryBuilder($qb);

        $qb
            ->select(' nw.slug')
            ->from('CertUnlpNgenBundle:Incident\State\Edge\StateEdge', 'e')
            ->innerJoin('e.newState', 'nw', 'WITH', 'e.newState = nw.slug')
            ->where('e.oldState = :state')
            ->setParameter('state', $state);

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
}
