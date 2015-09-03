<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\ShadowServer\Reports\Types;

use CertUnlp\NgenBundle\Services\ShadowServer\Reports\ShadowServerCsvRow;
use CertUnlp\NgenBundle\Services\Converter\IncidentConvertible;
use Gedmo\Sluggable\Util as Sluggable;

//use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;

/**
 * Description of ShadowServerReport
 *
 * @author demyen
 */
class ShadowServerReport implements IncidentConvertible {

    public function __construct(ShadowServerCsvRow $shadow_server_csv_row, $csv_evidence_file) {
        $this->shadow_server_csv_row = $shadow_server_csv_row;
        $this->csv_evidence_file = $csv_evidence_file;
    }

    public function getReportCsvRow() {
        return $this->getShadowServerCsvRow()->getCsvRow();
    }

    public function getShadowServerCsvRow() {
        return $this->shadow_server_csv_row;
    }

    public function getHostAddress() {
        return $this->getShadowServerCsvRow()->getIp();
    }

    public function getType() {
        return $this->getShadowServerCsvRow()->getReportFile();
    }

    public function getEvidenceFile() {
        return $this->csv_evidence_file;
    }

    public function getFeed() {
        return 'shadowserver';
    }

    public function getReporter() {
        return 'random';
    }

}
