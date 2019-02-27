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

use Exception;

/**
 * Description of RdapClient
 *
 * @author dam
 */
class RdapClient
{
    private $response;
    private $resources_path;
    private $entities;
    private $request_url;

    public function __construct($resources_path)
    {
        $this->resources_path = $resources_path;
        $this->entities = [];
        $this->request_url = 'https://rdap.arin.net/registry/ip/';
    }

    /**
     * @param $ip
     * @return RdapResultWrapper|null
     */
    public function requestIp($ip)
    {
        try {
            $result_file = $this->request_url . $ip;
            return $this->request($result_file);
        } catch (Exception $exc) {
            throw new \RuntimeException('Request Limit', 400);
        }
    }

    /**
     * @param $url
     * @return RdapResultWrapper|null
     * @throws Exception
     */
    public function request($url)
    {
        try {
            $this->setResponse(new RdapResultWrapper(file_get_contents($url)));
            return $this->response;
        } catch (Exception $exc) {
            throw new \RuntimeException('Request Limit', 400);
        }
    }

    /**
     * @param $link
     * @return Entity
     */
    public function requestEntity($link)
    {
        try {
            return new Entity(json_decode(file_get_contents($link)));
        } catch (Exception $exc) {
            throw new \RuntimeException($exc);
        }
    }

    /**
     * @return RdapResultWrapper
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param RdapResultWrapper $response
     */
    public function setResponse(RdapResultWrapper $response)
    {
        $this->response = $response;
    }


}
