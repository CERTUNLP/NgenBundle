<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;

class IncidentDecisionHandler extends Handler
{
    public function getByIncident(Incident $incident): ?IncidentDecision
    {
        $parameters = ['type' => $incident->getType() ? $incident->getType()->getSlug() : 'undefined', 'feed' => $incident->getFeed() ? $incident->getFeed()->getSlug() : 'undefined', 'network' => $incident->getNetwork() ? $incident->getNetwork()->getId() : null];
        return parent::get($parameters);
    }

    /**
     * Delete a Network.
     *
     * @param IncidentDecision $incident_decision
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($incident_decision, array $parameters = null)
    {
        $incident_decision->setIsActive(FALSE);
    }

    protected function checkIfExists($incidentDecision, $method)
    {
        $incidentDecisionDB = $this->repository->findOneBy(array('feed' => $incidentDecision->getFeed(), 'type' => $incidentDecision->getType(), 'network' => $incidentDecision->getNetwork()));

        if ($incidentDecisionDB && $method === 'POST') {
            $incidentDecision = $incidentDecisionDB;
        }
        return $incidentDecision;
    }

}