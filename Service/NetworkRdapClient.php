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
use Metaregistrar\RDAP\Data\RdapEntity;
use Metaregistrar\RDAP\Rdap;
use Metaregistrar\RDAP\RdapException;
use Metaregistrar\RDAP\Responses\RdapResponse;

class NetworkRdapClient
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
    /**
     * @var Rdap
     */
    private $rdap;
    /**
     * @var RdapResponse
     */
    private $response;


    public function __construct(NetworkEntityRepository $network_entity_repository, NetworkAdminRepository $network_admin_repository, ContactCaseRepository $contact_case_repository)
    {
        $this->network_entity_repository = $network_entity_repository;
        $this->network_admin_repository = $network_admin_repository;
        $this->contact_case_repository = $contact_case_repository;
        $this->rdap = new Rdap();
    }

    /**
     * @param string $ip
     * @return NetworkRdap|null
     * @throws RdapException
     */
    public function findByIp(string $ip): ?NetworkRdap
    {
        $response = $this->getRdap()->search($ip);
        if ($response) {
            $this->setResponse($response);
            $admin = $this->getNetworkAdmin();
            if ($admin) {
                $network = new NetworkRdap($response->getStartAddress() . '/' . $this->getCidrMask());
                $network->setNetworkAdmin($admin);
                $network->setNetworkEntity($this->getNetworkEntity());
                $network->setCountryCode($response->getCountry());
                return $network;
            }
        }
        return null;
    }

    /**
     * @return Rdap
     */
    public function getRdap(): Rdap
    {
        return $this->rdap;
    }

    /**
     * @return NetworkAdmin|null
     */
    public function getNetworkAdmin(): ?NetworkAdmin
    {
        $abuse_entity = $this->getAbuseEntity($this->getResponse()->getEntities());
        if ($abuse_entity) {
            $admin = $this->getNetworkAdminRepository()->findOneByName($this->getAbuseEntityName($abuse_entity));
            if (!$admin) {
                $admin = $this->createNetworkAdmin($abuse_entity);
            }
            return $admin;
        }
        return null;
    }

    /**
     * @param array $entities
     * @return NetworkAdmin|null
     */
    public function getAbuseEntity(array $entities): ?RdapEntity
    {
        foreach ($entities as $entity) {
            if ($this->isAbuseOrTechnicalEntity($entity)) {
                return $entity;
            }
            $abuse_entity = $this->getAbuseEntity($entity->getEntities());
            if ($abuse_entity) {
                return $abuse_entity;
            }
        }
        return null;
    }

    /**
     * @param RdapEntity $entity
     * @return bool
     */
    private function isAbuseOrTechnicalEntity(RdapEntity $entity): bool
    {
        return in_array('abuse', $entity->getRoles(), true);
    }

    /**
     * @return RdapResponse
     */
    public function getResponse(): RdapResponse
    {
        return $this->response;
    }

    /**
     * @param RdapResponse $response
     * @return NetworkRdapClient
     */
    public function setResponse(RdapResponse $response): NetworkRdapClient
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return NetworkAdminRepository
     */
    public function getNetworkAdminRepository(): NetworkAdminRepository
    {
        return $this->network_admin_repository;
    }

    /**
     * @param RdapEntity $abuse_entity
     * @return string|null
     */
    public function getAbuseEntityName(RdapEntity $abuse_entity): ?string
    {
        if ($abuse_entity) {
            $name = $this->getEntityName($abuse_entity);
            $handle = $abuse_entity->getHandle() ? '(' . $abuse_entity->getHandle() . ')' : '';
            if ($name) {
                return $name . $handle;
            }
        }
        return null;
    }

    /**
     * @param RdapEntity $entity
     * @return string|null
     */
    public function getEntityName(RdapEntity $entity): ?string
    {
        foreach ($entity->getVcards() as $vcards) {
            foreach ($vcards as $vcard) {
                if ($vcard->getName() === 'fn') {
                    return $vcard->getContentSimple();
                }
            }
        }
        return null;
    }

    /**
     * @param RdapEntity $abuse_entity
     * @return NetworkAdmin
     */
    private function createNetworkAdmin(RdapEntity $abuse_entity): ?NetworkAdmin
    {
        $name = $this->getAbuseEntityName($abuse_entity);
        $abuse_contacts = $this->getAbuseEntityContact($abuse_entity);
        if ($name && $abuse_contacts) {
            $admin = new NetworkAdmin();
            $admin->setName($name);

            foreach ($abuse_contacts as $abuse_contact) {
                $contact = new Contact();
                $contact->setUsername($abuse_contact['email']);
                $contact->setName($abuse_contact['name']);
                $contact->setNetworkAdmin($admin);
                $contact->setContactType('email');
                $contact->setContactCase($this->getContactCaseRepository()->findOneBySlug('all'));
                $admin->addContact($contact);
            }
            return $admin;
        }
        return null;
    }

    /**
     * @param RdapEntity $abuse_entity
     * @return array
     */
    public function getAbuseEntityContact(RdapEntity $abuse_entity): array
    {
        $contact = [];
        foreach ($abuse_entity->getVcards() as $id => $vcards) {
            foreach ($vcards as $vcard) {
                if ($vcard->getName() === 'fn') {
                    $contact[$id]['name'] = $vcard->getContentSimple();
                }
                if ($vcard->getName() === 'email') {
                    $contact[$id]['email'] = $vcard->getContentSimple();
                }
            }
            if (!isset($contact[$id]['email'])) {
                unset($contact[$id]);
            }
        }
        return $contact;
    }

    /**
     * @return ContactCaseRepository
     */
    public function getContactCaseRepository(): ContactCaseRepository
    {
        return $this->contact_case_repository;
    }

    /**
     * @return int
     */
    public function getCidrMask(): int
    {
        foreach ($this->getResponse()->getCidrs() as $cidr) {
            if ($cidr['v4prefix'] === $this->getResponse()->getStartAddress()) {
                return $cidr['length'];
            }
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
    public function getStartAddress(): string
    {
        $response = $this->getResponse()->getStartAddress();
        if (strpos($response, '/') !== false) {
            $response = explode('/', $response)[0];
        }
        return $response;
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
        $name = $this->getNetworkEntityName() ?? 'Undefined';
        $network_entity = $this->getNetworkEntityRepository()->findOneByName($name);
        if (!$network_entity) {
            $network_entity = new NetworkEntity();
            $network_entity->setName($name);
        }
        return $network_entity;
    }

    /**
     * @return string|null
     */
    public function getNetworkEntityName(): ?string
    {
        $name = $this->getResponse()->getName() ?: 'Undefined';
        $handle = $this->getResponse()->getHandle() ?: 'Undefined';
        return $name . ' (' . $handle . ')';
    }

    /**
     * @return NetworkEntityRepository
     */
    public function getNetworkEntityRepository(): NetworkEntityRepository
    {
        return $this->network_entity_repository;
    }

}
