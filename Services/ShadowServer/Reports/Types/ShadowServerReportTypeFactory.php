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

/**
 * Description of TypeFactory
 *
 * @author demyen
 */
class ShadowServerReportTypeFactory {

    public function getReportTypeFromCsvRow($csv_row, $file_path, $csv_evidence_file) {
        $file = explode('-', basename($file_path))[0];
        $shadow_server_csv_row = new ShadowServerCsvRow($csv_row, $file);
        $type = __NAMESPACE__ . "\\" . preg_replace('/(?:^|_)(.?)/e', "strtoupper('$1')", $file); //CamelCase
        if (class_exists($type)) {
            return new $type($shadow_server_csv_row, $csv_evidence_file);
        } else {
            echo "[shadowserver]The class $type does not exist \n";
            return null;
        }
    }

}
