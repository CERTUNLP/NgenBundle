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

use CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport;

class IncidentReportHandler extends Handler
{

    /**
     * Delete a IncidentReport.
     *
     * @param IncidentReport $incident_report
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($incident_report, array $parameters = null)
    {
        $incident_report->setIsActive(FALSE);
    }

    protected function checkIfExists($incident_report, $method)
    {
        return $incident_report;
    }

}
