<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Rdap;

use Exception;

/**
 * Description of RdapClient
 *
 * @author dam
 */
class RdapClient
{
    /**
     * @var RdapResultWrapper
     */
    private $response;
    /**
     * @var string
     */
    private $request_url;
    /**
     * @var string
     */
    private $team_mail;

    public function __construct(string $team_mail)
    {
        $this->team_mail = $team_mail;
//        $this->request_url = 'https://rdap.arin.net/registry/ip/';
        $this->request_url = 'https://rdap.lacnic.net/rdap/ip/';
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
     * @return RdapClient
     */
    public function setResponse(RdapResultWrapper $response): RdapClient
    {
        $this->response = $response;
        return $this;
    }

    public function requestIp(string $ip): ?RdapResultWrapper
    {
        try {
            $result_file = $this->getRequestUrl() . $ip;
            return $this->request($result_file);
        } catch (Exception $exc) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->request_url;
    }

    /**
     * @param string $url
     * @return RdapResultWrapper|null
     */
    public function request(string $url): ?RdapResultWrapper
    {
        try {
            $this->setResponse(new RdapResultWrapper(file_get_contents($url)));
            return $this->response;
        } catch (Exception $exc) {
            return null;
        }
    }

    /**
     * @param string $link
     * @return Entity
     */
    public function requestEntity(string $link): Entity
    {
        if ($link) {
            try {
                return new Entity(json_decode(file_get_contents($link), false));
            } catch (Exception $exc) {
                return new DefaultEntity(null, $this->getTeamMail());
            }
        } else {
            return new DefaultEntity(null, $this->getTeamMail());
        }

    }

    /**
     * @return string
     */
    public function getTeamMail(): string
    {
        return $this->team_mail;
    }


}
