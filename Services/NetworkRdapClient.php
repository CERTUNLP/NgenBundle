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

use CertUnlp\NgenBundle\Entity\Contact\ContactCase;
use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
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

            $network_new = $this->findByIp($incident->getAddress());
            if ($network_new) {
                $incident->setNetwork();
            }
        }
        return $incident;
    }

    public function findByIp(string $ip): ?NetworkRdap
    {

        $this->setResponse($this->requestIp($ip));
        $network = new NetworkRdap($this->getStartAddress() . '/' . $this->getCidrMask());
        $this->seachForAbuseEntities();
        $network->setNetworkAdmin($this->getNetworkAdmin());
        $network->setNetworkEntity($this->getNetworkEntity());
        $network->setCountryCode($this->getCountry());
        return $network;
    }

    /**
     * @return string
     */
    public function getStartAddress(): string
    {
        $response = $this->getResponse()->getStartAddress();
        if (strpos($response, '/') !== false) {
            $response = explode('/', $response)[0];
        }
        return $response;
    }

    /**
     * @return int
     */
    public function getCidrMask(): int
    {
        if ($this->getResponse()->getCidr() !== 0) {
            return $this->getResponse()->getCidr();
        }

        return $this->getMaskFromAddresses();
    }

    public function getMaskFromAddresses(): int
    {
        if ($this->getResponse()->getIpVersion() === 'v6') {
            $start = explode(':', $this->getStartAddress());
            $end = explode(':', $this->getEndAddress());
            $result = 128 - 16 * count(array_diff($end, $start));
        } else {
            $result = $this->calcularMaskV4($this->getStartAddress(), $this->getEndAddress());
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getEndAddress(): string
    {
        $response = $this->getResponse()->getEndAddress();
        if (strpos($response, '/') != false) {
            $response = explode('/', $response)[0];
        }
        return $response;

    }

    private function calcularMaskV4($startStr, $endStr)
    {
        $start = ip2long($startStr);
        $end = ip2long($endStr);
        $maxSize = 32;
        while ($maxSize > 0) {
            $mask = hexdec($this->iMask($maxSize - 1));
            $maskBase = $start & $mask;
            if ($maskBase !== $start) {
                break;
            }
            $maxSize--;
        }
        $x = log($end - $start + 1) / log(2);
        $maxDiff = floor(32 - floor($x));
        if ($maxSize < $maxDiff) {
            $maxSize = $maxDiff;
        }
        return $maxSize;

    }

    private function iMask($s)
    {
        return base_convert((2 ** 32) - (2 ** (32 - $s)), 10, 16);
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
        $admin = new NetworkAdmin($this->getAbuseEntity());

        foreach ($this->getAbuseEntityEmails() as $email) {
            $contact = new ContactEmail();
            $contact->setUsername($email);
            $contact->setName($this->getAbuseEntity());
            $contact->setNetworkAdmin($admin);
            $contact->setContactType('email');
            $contact->setContactCase($this->getDoctrine()->getRepository(ContactCase::class)->findOneBySlug('all'));
            $admin->addContact($contact);
        }
        return $admin;
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
    public function getCountry(): string
    {
        return $this->getResponse()->getCountry();
    }

}
