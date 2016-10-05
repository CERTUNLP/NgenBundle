<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Services\Rdap\RdapClient;
use CertUnlp\NgenBundle\Entity\ExternalIncident;

class IncidentRdapClient extends RdapClient {

    public function prePersistDelegation(ExternalIncident $incident) {
        $this->response = $this->request($incident->getHostAddress());
        $incident->setAbuseEntity($this->getAbuseEntity());
        $incident->setAbuseEntityEmails($this->getAbuseEntityEmails());
        $incident->setNetworkEntity($this->getNetworkEntity());
        $incident->setStartAddress($this->getStartAddress());
        $incident->setEndAddress($this->getEndAddress());
        $incident->setCountry($this->getCountry());
    }

    public function getAbuseEntity() {
        return $this->response->getAbuseEntity()->getName();
    }

    public function getAbuseEntityEmails() {
        return $this->response->getAbuseEntity()->getEmails('fn');
    }

    public function getNetworkEntity() {
        return $this->response->getName() . " (" . $this->response->getHandle() . ")";
    }

    public function getStartAddress() {
        return $this->response->getStartAddress();
    }

    public function getEndAddress() {
        return $this->response->getEndAddress();
    }

    public function getCountry() {
        return $this->response->getCountry();
    }

}
