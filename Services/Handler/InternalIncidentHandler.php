<?php

/*
 * This file is part of the Ngen - CSIRT InternalIncident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Handler;

use CertUnlp\NgenBundle\Services\Handler\IncidentHandler;

class InternalIncidentHandler extends IncidentHandler {

    protected function prepareToDeletion($incident, array $parameters) {
        $incident->close();
    }

    protected function checkIfExists($incident, $method) {
        $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'hostAddress' => $incident->getHostAddress(), 'type' => $incident->getType()]);
        if ($incidentDB && $method == 'POST') {

            if ($incident->getFeed()->getSlug() == "shadowserver") {
                $incidentDB->setSendReport(false);
            } else {
                $incidentDB->setSendReport($incident->getSendReport());
            }

            if ($incident->getEvidenceFile()) {
                $incidentDB->setEvidenceFile($incident->getEvidenceFile());
            }

            $incident = $incidentDB;
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return $incident;
    }

    public function closeOldIncidents($days = 10) {
        $incidents = $this->all(['isClosed' => false]);
        $state = $this->om->getRepository('CertUnlp\NgenBundle\Entity\IncidentState')->findOneBySlug('closed_by_inactivity');
        $closedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->getOpenDays(true) >= $days) {
                $incident->setState($state);
                $this->om->persist($incident);
                $closedIncidents[$incident->getId()] = ['hostAddress' => $incident->getHostAddress(),
                    'type' => $incident->getType(),
                    'date' => getDate(),
                    'lastTimeDetected' => $incident->getLastTimeDetected(),
                    'openDays' => $incident->getOpenDays(true)];
            }
            $this->om->flush($incident);
        }
        return $closedIncidents;
    }

    public function renotificateIncidents() {
        return $this->repository->findRenotificables();
    }

}
