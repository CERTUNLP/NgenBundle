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
use RuntimeException;

/**
 * Description of RdapClient
 *
 * @author dam
 */
class RdapClient
{
    private $response;
    private $request_url;
    private $team;
    private $doctrine;

    public function __construct(array $team, $doctrine)
    {
        $this->team = $team;
        $this->doctrine = $doctrine;
//        $this->request_url = 'https://rdap.arin.net/registry/ip/';
        $this->request_url = 'https://rdap.lacnic.net/rdap/ip/';
    }

    /**
     * @return mixed
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param mixed $doctrine
     * @return RdapClient
     */
    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;
        return $this;
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
     * @return RdapClient
     */
    public function setRequestUrl(string $request_url): RdapClient
    {
        $this->request_url = $request_url;
        return $this;
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
            return null;
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
            return null;
        }
    }

    /**
     * @param $link
     * @return Entity| DefaultEntity
     */
    public function requestEntity(string $link)
    {
        if ($link) {
            try {
                return new Entity(json_decode(file_get_contents($link)));
            } catch (Exception $exc) {
                return new DefaultEntity(null, $this->getTeam()['mail']);
            }
        } else {
            return new DefaultEntity(null, $this->getTeam()['mail']);
        }

    }

    /**
     * @return array
     */
    public function getTeam(): array
    {
        return $this->team;
    }

    /**
     * @param array $team
     * @return RdapClient
     */
    public function setTeam(array $team): RdapClient
    {
        $this->team = $team;
        return $this;
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
