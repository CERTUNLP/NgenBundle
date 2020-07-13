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

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HostRepository extends NetworkElementRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Host::class);
    }
}
