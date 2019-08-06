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

/**
 * IncidentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IncidentRepository extends NetworkElementRepository
{

    public function findByHostDateType($parameters): ?Incident
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.type = :type')
            ->andWhere('i.ip = :ip')
            ->andWhere('i.date = :date')
//                ->andWhere('i.isClosed = :closed')
            ->setParameter('type', $parameters['type'])
            ->setParameter('ip', $parameters['ip'])
//                ->setParameter('closed', FALSE)
            ->setParameter('date', $parameters['date']);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findRenotificables($parameters = [])
    {
        $query = $this->createQueryBuilder('i')
//                ->select('count(i)')
            ->where('i.isClosed = :closed')
//                ->andWhere('DATE_DIFF(:date,i.date) = 15')
//                ->orWhere('DATE_DIFF(:date,i.renotificationDate) = 5')
            ->setParameter('closed', FALSE)
            ->setParameter('date', new \DateTime('-1 days'));

        return $query->getQuery()->getResult();
    }
    public function findNotificables($parameters = [])
    {
        $query = $this->createQueryBuilder('i')
          ->where('i.id = :id')
          ->setParameter('id', 135592);

        return $query->getQuery()->getResult();
    }
public function findByTypeAndAddress($type,$address) {
    $qb = $this->createQueryBuilder('i');

    $qb->select('i')
        ->innerJoin('i.origin', 'h')
        ->where($qb->expr()->orX(
            $qb->expr()->eq('h.ip', ':address'),
            $qb->expr()->eq('h.domain', ':address')
        ))
        ->andWhere('i.type = :type')
        ->andWhere('i.isClosed = :closed')
        ->setParameter('type', $type)
        ->setParameter('address', $address)
        ->setParameter('closed', FALSE);

    return $qb->getQuery()->getResult();

    }


}
