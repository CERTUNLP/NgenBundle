<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

use CertUnlp\NgenBundle\Services\Rdap\RdapResultWrapper;
/**
 * Description of RdapClient
 *
 * @author dam
 */
use Exception;

class RdapClient {

    public function __construct($resources_path) {
        $this->resources_path = $resources_path;
        $this->entities = [];
        $this->response = null;
    }

    public function request($ip) {
        try {

            $result_file = 'https://rdap.arin.net/registry/ip/' . $ip;
            $this->response = new RdapResultWrapper(file_get_contents($result_file));

            return $this->response;
        } catch (Exception $exc) {
            return $exc;
        }
    }

    public function getResponse() {
        $this->response;
    }

}
