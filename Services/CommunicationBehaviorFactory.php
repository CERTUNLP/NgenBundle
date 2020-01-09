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

use CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use Doctrine\Common\Collections\ArrayCollection;


class CommunicationBehaviorFactory
{

    private $entityManager;

    public function __construct(EntityManager $entityManager, $securityTeam)
    {
        $this->entityManager = $entityManager;
    }

    public function getFromDecision(IncidentDetected $incidentDetected)
    {

    }
    public function getFromTemplate(): ArrayCollection
    {
        $repository = $this->entityManager->getRepository(CommunicationBehavior::class);
        return new ArrayCollection($repository->findBy(['type' => 'new','mode'=>'manual']));

    }

}
