<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\ShadowServer\Reports;

/**
 * Description of ShadowServerCsvRow
 *
 * @author demyen
 */
class ShadowServerCsvRow
{

    private $report_file;
    private $csv_row;

    public function __construct($csv_row, $report_file)
    {
        $this->csv_row = $csv_row;
        $this->report_file = $report_file;
    }

    public function getCsvRow()
    {
        return $this->csv_row;
    }

    public function getReportFile()
    {
        return $this->report_file;
    }

    public function getIp()
    {
        return $this->csv_row['ip'];
    }

}
