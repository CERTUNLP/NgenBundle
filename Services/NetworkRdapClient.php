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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use CertUnlp\NgenBundle\Entity\Network\NetworkRdap;
use CertUnlp\NgenBundle\Services\Rdap\RdapClient;

class NetworkRdapClient extends RdapClient
{

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function prePersistDelegation(Incident $incident): Incident
    {
        $network = $incident->getNetwork();
        if (!$network || $network instanceof NetworkRdap) {

            $network_new = $this->findByIpV4($incident->getIp());
            if ($network_new) {
                $incident->setNetwork();
            }
        }
        return $incident;
    }

    public function findByIpV4(string $ip): ?NetworkRdap
    {
        $this->setResponse($this->requestIp($ip));

        $network = new NetworkRdap();
        $this->seachForAbuseEntities();
        $network->setNetworkAdmin($this->getNetworkAdmin());
//            $network->setAbuseEntityEmails($this->getAbuseEntityEmails());
        $network->setNetworkEntity($this->getNetworkEntity());
        $network->setStartAddress($this->getStartAddress());
        $network->setEndAddress($this->getEndAddress());
        $network->setCountry($this->getCountry());
        return $network;
    }

    public function seachForAbuseEntities(): void
    {
        if ($this->getResponse()->getAbuseEntities()) {
            foreach ($this->getResponse()->getAbuseEntities() as $index => $abuse) {
                if (!$abuse->getEmails()) {
                    $new_entity = $this->requestEntity($abuse->getSelfLink());
                    if ($new_entity->getEmails()) {
                        $abuse->getObject()->vcardArray = $new_entity->getObject()->vcardArray;
                    }
                }
            }
        }
    }

    /**
     * @return NetworkAdmin
     */
    public function getNetworkAdmin(): NetworkAdmin
    {
        return new NetworkAdmin($this->getAbuseEntity(), $this->getAbuseEntityEmails());
    }

    /**
     * @return mixed
     */
    public function getAbuseEntity(): string
    {
        if ($this->getResponse()->getAbuseEntity()) {
            return $this->getResponse()->getAbuseEntity()->getName();
        }
        return '';
    }

    /**
     * @return array
     */
    public function getAbuseEntityEmails(): array
    {
        if ($this->getResponse()->getAbuseEntity()) {
            return $this->getResponse()->getAbuseEntity()->getEmails();
        }
        return [];
    }

    /**
     * @return NetworkEntity
     */
    public function getNetworkEntity(): NetworkEntity
    {
        return new NetworkEntity($this->getResponse()->getName() . ' (' . $this->getResponse()->getHandle() . ')');
    }

    /**
     * @return string
     */
    public function getStartAddress(): string
    {
        return $this->getResponse()->getStartAddress();
    }

    /**
     * @return string
     */
    public function getEndAddress(): string
    {
        return $this->getResponse()->getEndAddress();
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->getResponse()->getCountry();
    }

}
