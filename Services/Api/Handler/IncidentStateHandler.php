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

use CertUnlp\NgenBundle\Entity\Incident\IncidentState;

class IncidentStateHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param IncidentState $incident_state
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($incident_state, array $parameters = null)
    {
        $incident_state->setIsActive(FALSE);
    }

    protected function checkIfExists($incident_state, $method)
    {
        $incident_stateDB = $this->repository->findOneBy(['slug' => $incident_state->getSlug()]);

        if ($incident_stateDB && $method == 'POST') {
            if (!$incident_stateDB->getIsActive()) {
                $incident_stateDB->setIsActive(TRUE);
            }
            $incident_state = $incident_stateDB;
        }
        return $incident_state;
    }

}
