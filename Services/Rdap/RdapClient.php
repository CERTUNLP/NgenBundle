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
        $this->request_url = 'https://rdap.arin.net/registry/ip/';
    }

    public function request($url) {
        try {
            $this->response = new RdapResultWrapper(file_get_contents($url));

            return $this->response;
        } catch (Exception $exc) {
            var_dump($exc);
            die;

            throw new Exception("Request Limit", 400);
        }
    }

    public function requestIp($ip) {
        try {
            $result_file = $this->request_url . $ip;
            return $this->request($result_file);
        } catch (Exception $exc) {
            throw new Exception("Request Limit", 400);
        }
    }

    public function requestEntity($link) {
        try {
            return new Entity(json_decode(file_get_contents($link)));
        } catch (Exception $exc) {
            throw new Exception($exc);
        }
    }

    public function getResponse() {
        $this->response;
    }

}
