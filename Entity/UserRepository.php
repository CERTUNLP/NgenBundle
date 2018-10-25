<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IncidentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    public function findOneRandom()
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('CertUnlpNgenBundle:User', 'u')
            ->where('u.enabled = 1');
        $users = $qb->getQuery()->getResult();
        shuffle($users);

        foreach ($users as $user) {
            if (!in_array($user->getUsername(), array('nmacia', 'elanfranco', 'pvenosa', 'mailbot', 'bro', 'scanner'))) {
                return $user;
            }
        }
    }

}
