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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class MessageRepository extends ServiceEntityRepository
{

    /**
     * @return int|mixed|string
     * @deprecated findByPending instead
     */
    public function findMessagesToSend()
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.pending = :state')
            ->setParameter('state', TRUE);

        return $query->getQuery()->getResult();
    }


}
