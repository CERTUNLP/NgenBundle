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

use CertUnlp\NgenBundle\Entity\Incident\NetworkExternal;
use CertUnlp\NgenBundle\Services\Rdap\RdapClient;
use Exception;

class IncidentRdapClient extends RdapClient
{

    public function prePersistDelegation(NetworkExternal $incident)
    {
        try {
            $this->setResponse($this->requestIp($incident->getHostAddress()));
            $this->seachForAbuseEntities();
            $incident->setAbuseEntity($this->getAbuseEntity());
            $incident->setAbuseEntityEmails($this->getAbuseEntityEmails());
            $incident->setNetworkEntity($this->getNetworkEntity());
            $incident->setStartAddress($this->getStartAddress());
            $incident->setEndAddress($this->getEndAddress());
            $incident->setCountry($this->getCountry());
        } catch (Exception $exc) {
            throw new Exception($exc);
        }
    }

    public function seachForAbuseEntities()
    {
        if ($this->getResponse()->getAbuseEntities()) {
            foreach ($this->getResponse()->getAbuseEntities() as $index => $abuse) {
                if (!$abuse->getEmails()) {
                    $new_entity = $this->requestEntity($abuse->getSelfLink());
                    if ($new_entity->getEmails()) {
                        $abuse->object->vcardArray = $new_entity->object->vcardArray;
                    }
                }
            }
        }
    }

    public function getAbuseEntity()
    {
        return $this->getResponse()->getAbuseEntity()->getName();
    }

    public function getAbuseEntityEmails()
    {
        return $this->getResponse()->getAbuseEntity()->getEmails('fn');
    }

    public function getNetworkEntity()
    {
        return $this->getResponse()->getName() . " (" . $this->getResponse()->getHandle() . ")";
    }

    public function getStartAddress()
    {
        return $this->getResponse()->getStartAddress();
    }

    public function getEndAddress()
    {
        return $this->getResponse()->getEndAddress();
    }

    public function getCountry()
    {
        return $this->getResponse()->getCountry();
    }

}
