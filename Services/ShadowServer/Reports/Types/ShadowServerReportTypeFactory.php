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
use CertUnlp\NgenBundle\Services\ShadowServer\Reports\Types\ShadowServerReport;

/**
 * Description of TypeFactory
 *
 * @author demyen
 */
class ShadowServerReportTypeFactory {

    public function getReportTypeFromCsvRow($csv_row, $file_path, $csv_evidence_file) {
        $file = explode('-', basename($file_path))[0];
        $file = str_replace("scan", "open", $file);
        switch ($file) {
            case 'dns_openresolver':
                $file = 'open_dns';
                break;
            case 'open_ntp':
                $file = 'open_ntp_version';
                break;
            case 'open_ntpmonitor':
                $file = 'open_ntp_monitor';
                break;
            case 'open_portmapper':
                $file = 'open_portmap';
                break;
            case 'open_ssl_poodle':
                $file = 'poodle';
                break;

            default:
                break;
        }
        $shadow_server_csv_row = new ShadowServerCsvRow($csv_row, $file);
//        var_dump(str_replace("scan", "open", $file));
//        $type = __NAMESPACE__ . "\\" . preg_replace_callback('/(?:^|_)(.?)/', function ($coincidencias) {
//                    return strtoupper($coincidencias[0]);
//                }, $file); //CamelCase
//        if (class_exists($type)) {
        return new ShadowServerReport($shadow_server_csv_row, $csv_evidence_file);
//        } else {
//            echo "[shadowserver]The class $type does not exist \n";
//            return null;
//        }
    }

}
