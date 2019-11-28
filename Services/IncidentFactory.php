<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use Doctrine\ORM\EntityManager;


class IncidentFactory
{

    private $entityManager;
    private $team;

    public function __construct(EntityManager $entityManager, $securityTeam, array $team)
    {
        $this->entityManager = $entityManager;
        $this->team = $team;
    }

    public function getIncident()
    {  $repository = $this->entityManager->getRepository(IncidentTlp::class);
        $newTLP = $repository->findOneBySlug('white');
        $incident = new Incident();
        $incident->setTlp($newTLP);
        $incident->setNetwork(new NetworkInternal());
        return $incident;
    }

    /**
     * @return array
     */
    public function getTeam(): array
    {
        return $this->team;
    }
}
