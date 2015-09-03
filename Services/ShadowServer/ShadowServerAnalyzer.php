<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\ShadowServer;

use CertUnlp\NgenBundle\Model\AbstractAnalyzer;
use CertUnlp\NgenBundle\Services\ShadowServer\ShadowServerClient;

/**
 * Description of ShadowServerAnalyzer
 *
 * @author demyen
 */
class ShadowServerAnalyzer extends AbstractAnalyzer {

    public function __construct($shadow_server_client, $converter) {
        $this->shadow_server_client = $shadow_server_client;
        $this->converter = $converter;
    }

    public function analyze($daysAgo = '1', $username = null, $analyzeCache = null) {

        $params = ['daysAgo' => $daysAgo, 'username' => $username, 'analyzeCache' => $analyzeCache];
        parent::analyze($params);
    }

    public function input($params = null) {
        return $this->shadow_server_client->importCsv($params['daysAgo'], $params['analyzeCache']);
    }

    //no defino doAnalisys porq confiamos en q funcionan los reportes

    public function output($analyze_output = null) {
        foreach ($analyze_output as $imported_report) {
            $this->converter->convert($imported_report);
        }
    }

}
