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

    public function __construct(string $resources_path)
    {
        $this->resources_path = $resources_path;
        $this->entities = [];
        $this->response;
        $this->request_url = 'https://rdap.arin.net/registry/ip/';
    }

    /**
     * @return mixed
     */
    public function getResourcesPath(): string
    {
        return $this->resources_path;
    }

    /**
     * @param mixed $resources_path
     */
    public function setResourcesPath(string $resources_path): void
    {
        $this->resources_path = $resources_path;
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
    }

    /**
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->request_url;
    }

    /**
     * @param string $request_url
     */
    public function setRequestUrl(string $request_url): void
    {
        $this->request_url = $request_url;
    }

    /**
     * @param $ip
     * @return RdapResultWrapper|null
     * @throws Exception
     */
    public function requestIp(string $ip): RdapResultWrapper
    {
        try {
            $result_file = $this->request_url . $ip;
            return $this->request($result_file);
        } catch (Exception $exc) {
            throw new Exception("Request Limit", 400);
        }
    }

    /**
     * @param $url
     * @return RdapResultWrapper
     * @throws Exception
     */
    public function request(string $url): RdapResultWrapper
    {
        try {
            $this->setResponse(new RdapResultWrapper(file_get_contents($url)));

            return $this->response;
        } catch (Exception $exc) {
            throw new Exception("Request Limit", 400);
        }
    }

    /**
     * @param $link
     * @return Entity
     * @throws Exception
     */
    public function requestEntity(string $link): Entity
    {
        try {
            return new Entity(json_decode(file_get_contents($link)));
        } catch (Exception $exc) {
            throw new Exception($exc);
        }
    }

    /**
     * @return RdapResultWrapper
     */
    public function getResponse(): RdapResultWrapper
    {
        return $this->response;
    }

    /**
     * @param RdapResultWrapper $response
     */
    public function setResponse(RdapResultWrapper $response): void
    {
        $this->response = $response;
    }


}
