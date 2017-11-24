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

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Services\Api\Handler\Handler;

class IncidentReportHandler extends Handler {

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $incident_report
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function prepareToDeletion($incident_report, array $parameters = null) {
        $incident_report->setIsActive(FALSE);
    }

    protected function checkIfExists($incident_report, $method) {
        $incident_reportDB = $this->repository->findOneBy(['lang' => $incident_report->getLang(), 'type' => $incident_report->getType()]);

//        if ($incident_reportDB && $method == 'POST') {
//            if (!$incident_reportDB->getIsActive()) {
//                $incident_reportDB->setIsActive(TRUE);
//            }
//            $incident_report = $incident_reportDB;
//        }
        return $incident_report;
    }

}
