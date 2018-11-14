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

use CertUnlp\NgenBundle\Entity\IncidentDecision;

class IncidentDecisionHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param IncidentDecision $incident_decision
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($incidentDecision, array $parameters = null)
    {
        $incidentDdecision->setIsActive(FALSE);
    }

    protected function checkIfExists($incidentDecision, $method)
    {
        $incidentDecisionDB = $this->repository->findOneBy(array(feed' => $incidentDecision->getFeed(),'type'=> $incidentDecision->getType()));

        if ($incidentDecisionDB && $method == 'GET') {
            $incidentDecision = $incidentDecisionDB;
        }
        return $incidentDecision;
    }

}