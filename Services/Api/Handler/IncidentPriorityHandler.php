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

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;

class IncidentPriorityHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param IncidentPriority $incident_priority
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion(
        $incident_priority, array $parameters = null)
    {
        $incident_priority->setIsActive(FALSE);
    }

    protected function checkIfExists($incidentPriority, $method)
    {
        $incidentPriorityDB = $this->repository->findOneBy(array('code' => $incidentPriority->getCode()));

        if ($incidentPriorityDB && $method == 'GET') {
            $incidentPriority = $incidentPriorityDB;
        }
        return $incidentPriority;
    }

}