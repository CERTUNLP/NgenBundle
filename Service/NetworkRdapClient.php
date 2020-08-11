<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service;

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\NetworkRdap;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Repository\ContactCaseRepository;
use CertUnlp\NgenBundle\Repository\NetworkAdminRepository;
use CertUnlp\NgenBundle\Repository\NetworkEntityRepository;
use CertUnlp\NgenBundle\Service\Rdap\RdapClient;

class NetworkRdapClient extends RdapClient
{

    /**
     * @var NetworkEntityRepository
     */
    private $network_entity_repository;
    /**
     * @var NetworkAdminRepository
     */
    private $network_admin_repository;
    /**
     * @var ContactCaseRepository
     */
    private $contact_case_repository;


    public function __construct(string $team_mail, NetworkEntityRepository $network_entity_repository, NetworkAdminRepository $network_admin_repository, ContactCaseRepository $contact_case_repository)
    {
        parent::__construct($team_mail);
        $this->network_entity_repository = $network_entity_repository;
        $this->network_admin_repository = $network_admin_repository;
        $this->contact_case_repository = $contact_case_repository;
    }

    /**
     * @param string $ip
     * @return NetworkRdap|null
     */
    public function findByIp(string $ip): ?NetworkRdap
    {
        $response = $this->requestIp($ip);
        if ($response) {
            $this->setResponse($this->requestIp($ip));
            $admin = $this->getNetworkAdmin();
            if ($admin) {
                $network = new NetworkRdap($this->getStartAddress() . '/' . $this->getCidrMask());
                $network->setNetworkAdmin($admin);
                $network->setNetworkEntity($this->getNetworkEntity());
                $network->setCountryCode($this->getCountry());
                return $network;
            }
        }
        return null;
    }

    /**
     * @return NetworkAdmin|null
     */
    public function getNetworkAdmin(): ?NetworkAdmin
    {
        $this->seachForAbuseEntities();
        if ($this->getAbuseEntityName()) {
            $admin = $this->getNetworkAdminRepository()->findOneByName($this->getAbuseEntityName());
            if (!$admin) {
                $admin = $this->createNetworkAdmin();
            }
            return $admin;
        }
        return null;
    }

    public function seachForAbuseEntities(): void
    {
        if ($this->getResponse()->getAbuseEntities()) {
            foreach ($this->getResponse()->getAbuseEntities() as $index => $abuse) {
                if (!$abuse->getEmails()) {
                    $new_entity = $this->requestEntity($abuse->getSelfLink());
                    if ($new_entity && $new_entity->getEmails()) {
                        $abuse->getObject()->vcardArray = $new_entity->getObject()->vcardArray;
                    }
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getAbuseEntityName(): ?string
    {
        $abuse_entity = $this->getResponse()->getAbuseEntity();
        if ($abuse_entity) {
            return $abuse_entity->getName() . '(' . $abuse_entity->getHandle() . ')';
        }
        return null;
    }

    /**
     * @return NetworkAdminRepository
     */
    public function getNetworkAdminRepository(): NetworkAdminRepository
    {
        return $this->network_admin_repository;
    }

    /**
     * @return NetworkAdmin
     */
    private function createNetworkAdmin(): NetworkAdmin
    {
        $admin = new NetworkAdmin();
        $admin->setName($this->getAbuseEntityName());
        foreach ($this->getAbuseEntityEmails() as $email) {
            $contact = new Contact();
            $contact->setUsername($email);
            $contact->setName($this->getAbuseEntityName());
            $contact->setNetworkAdmin($admin);
            $contact->setContactType('email');
            $contact->setContactCase($this->getContactCaseRepository()->findOneBySlug('all'));
            $admin->addContact($contact);
        }
        return $admin;
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
     * @return ContactCaseRepository
     */
    public function getContactCaseRepository(): ContactCaseRepository
    {
        return $this->contact_case_repository;
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

    /**
     * @return int
     */
    public function getMaskFromAddresses(): int
    {
        if ($this->getResponse()->getIpVersion() === 'v6') {
            $start = explode(':', $this->getStartAddress());
            $end = explode(':', $this->getEndAddress());
            $result = 128 - 16 * count(array_diff($end, $start));
        } else {
            $result = $this->calculateMaskV4($this->getStartAddress(), $this->getEndAddress());
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getEndAddress(): string
    {
        $response = $this->getResponse()->getEndAddress();
        if (strpos($response, '/') !== false) {
            $response = explode('/', $response)[0];
        }
        return $response;

    }

    /**
     * @param string $startStr
     * @param string $endStr
     * @return int
     */
    private function calculateMaskV4(string $startStr, string $endStr): int
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

    /**
     * @param int $mask
     * @return string
     */
    private function iMask(int $mask): string
    {
        return base_convert((2 ** 32) - (2 ** (32 - $mask)), 10, 16);
    }

    /**
     * @return NetworkEntity
     */
    public function getNetworkEntity(): NetworkEntity
    {
        $network_entity = $this->getNetworkEntityRepository()->findOneByName($this->getNetworkEntityName() ?? 'Undefined');
        if (!$network_entity) {
            $network_entity = new NetworkEntity();
            $network_entity->setName($this->getNetworkEntityName());
        }
        return $network_entity;
    }

    /**
     * @return NetworkEntityRepository
     */
    public function getNetworkEntityRepository(): NetworkEntityRepository
    {
        return $this->network_entity_repository;
    }

    /**
     * @return string|null
     */
    public function getNetworkEntityName(): ?string
    {
        if ($this->getResponse()->getName()) {
            $handle = $this->getResponse()->getHandle() ? ' (' . $this->getResponse()->getHandle() . ')' : ' ';
            return $this->getResponse()->getName() . $handle;
        }
        return null;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->getResponse()->getCountry();
    }

}
