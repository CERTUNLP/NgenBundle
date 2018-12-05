<?php

/*
 * This file is part of the Ngen - CSIRT InternalIncident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\Incident;

class InternalIncidentHandler extends IncidentHandler
{

    public function closeOldIncidents($days = 10)
    {
        $incidents = $this->all(['isClosed' => false]);
        $state = $this->om->getRepository('CertUnlp\NgenBundle\Entity\Incident\IncidentState')->findOneBySlug('closed_by_inactivity');
        $closedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->getOpenDays(true) >= $days) {
                $incident->setState($state);
                $this->om->persist($incident);
                $closedIncidents[$incident->getId()] = ['ip' => $incident->getIp(),
                    'type' => $incident->getType(),
                    'date' => getDate(),
                    'lastTimeDetected' => $incident->getLastTimeDetected(),
                    'openDays' => $incident->getOpenDays(true)];
            }
            $this->om->flush();
        }
        return $closedIncidents;
    }

    public function renotificateIncidents()
    {
        return $this->repository->findRenotificables();
    }

    /**
     * @param $incident Incident
     * @param $method
     * @return object|null
     * @throws \Exception
     */
    protected function checkIfExists($incident, $method)
    {
        $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'origin' => $incident->getOrigin(), 'type' => $incident->getType()]);
//        var_dump($incident->getOrigin());die;
        if ($incidentDB && $method === 'POST') {
//            if ($incident->getFeed()->getSlug() === "shadowserver") {
//                $incidentDB->setSendReport(false);
//            } else {
//                $incidentDB->setSendReport($incident->isSendReport());
//            }

            if ($incident->getEvidenceFile()) {
                $incidentDB->setEvidenceFile($incident->getEvidenceFile());
            }

            $incident = $incidentDB;
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return $incident;
    }

}
