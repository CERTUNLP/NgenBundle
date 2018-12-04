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

class ExternalIncidentHandler extends IncidentHandler
{

    protected function prepareToDeletion($incident, array $parameters)
    {
        $incident->close();
    }

//    /**
//     * Processes the form.
//     *
//     * @param IncidentInterface $incident
//     * @param array         $parameters
//     * @param String        $method
//     *
//     * @return IncidentInterface
//     *
//     * @throws \CertUnlp\NgenBundle\Exception\InvalidFormException
//     */
//    protected function processForm($incident, $parameters, $method = "PUT", $csrf_protection = true) {
//        if (!isset($parameters['reporter']) || !$parameters['reporter']) {
//            $parameters['reporter'] = $this->getReporter();
//        }
//        return parent::processForm($incident, $parameters, $method, $csrf_protection);
//    }

    protected function checkIfExists($incident, $method)
    {
        $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'ip' => $incident->getIp(), 'type' => $incident->getType()]);
        if ($incidentDB && $method == 'POST') {

            if ($incident->getFeed()->getSlug() == "shadowserver") {
                $incidentDB->setSendReport(false);
            } else {
                $incidentDB->setSendReport($incident->isSendReport());
            }

            if ($incident->getEvidenceFile()) {
                $incidentDB->setEvidenceFile($incident->getEvidenceFile());
            }

            $incident = $incidentDB;
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return $incident;
    }

}
