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
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Repository\Communication\Contact\ContactCaseRepository;
use CertUnlp\NgenBundle\Repository\Constituency\NetworkAdminRepository;
use CertUnlp\NgenBundle\Repository\Constituency\NetworkEntityRepository;
use Metaregistrar\RDAP\Data\RdapEntity;
use Metaregistrar\RDAP\Rdap;
use Metaregistrar\RDAP\RdapException;
use Metaregistrar\RDAP\Responses\RdapResponse;
use Symfony\Component\HttpFoundation\IpUtils;

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
     * @param string $address
     * @return Network|null
     * @throws RdapException
     */
    public function search(string $address): ?Network
    {
        $response = $this->getRdap()->search($address);
        if ($response) {
            $this->setResponse($response);
            $admin = $this->getNetworkAdmin();
            $validated_address = $this->getAddress($address);
            if ($admin && $validated_address) {
                $network = new Network($validated_address);
                $network->setNetworkAdmin($admin);
                $network->setType('rdap');
                $network->setNetworkEntity($this->getNetworkEntity());
                $network->setCountryCode($this->getCountry());
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
            $name = $this->getEntityName($abuse_entity) ?: $this->getResponse()->getName() ?: 'Undefined';
            $handle = $abuse_entity->getHandle() ? ' (' . $abuse_entity->getHandle() . ')' : ' (' . ($this->getResponse()->getHandle() ?: 'Undefined') . ')';
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
                $contact->setName($abuse_contact['name'] ?: $name);
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
     * @param string $address
     * @return string
     */
    private function getAddress(string $address): ?string
    {
        if (in_array($this->getRdap()->getProtocol(), [$this->getRdap()::IPV4, $this->getRdap()::IPV6], true)) {
            $cidrs = $this->getCidrsFromAddresses();
            foreach ($cidrs as $cidr) {
                $prefix = $this->getResponse()->getIpVersion();
                if (IpUtils::checkIp($address, $cidr[$prefix . 'prefix'] . '/' . $cidr['length'])) {
                    return $cidr[$prefix . 'prefix'] . '/' . $cidr['length'];
                }
            }
            return null;
        }
        if ($this->getRdap()->getProtocol() === $this->getRdap()::DOMAIN) {
            return $this->getResponse()->getLDHName();
        }
        return $this->getResponse()->getHandle();
    }

    /**
     * @return array
     */
    public function getCidrsFromAddresses(): array
    {
        if ($this->getResponse()->getCidrs()) {
            return $this->getResponse()->getCidrs();
        }
        if ($this->getResponse()->getIpVersion() === 'v4') {
            return $this->getCidrV4($this->getResponse()->getStartAddress(), $this->getResponse()->getEndAddress());
        }
        return [];

    }

    /**
     * @param string $ipStart
     * @param string $ipEnd
     * @return array
     */
    private function getCidrV4(string $ipStart, string $ipEnd): array
    {
        if (is_string($ipStart) || is_string($ipEnd)) {
            $start = ip2long($ipStart);
            $end = ip2long($ipEnd);
        } else {
            $start = $ipStart;
            $end = $ipEnd;
        }

        $result = array();

        while ($end >= $start) {
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

            $ip = long2ip($start);
            $result[] = ['v4prefix' => $ip, 'length' => (int)$maxSize];
            $start += 2 ** (32 - $maxSize);
        }
        return $result;
    }

    /**
     * @param int $mask
     * @return string
     */
    private function iMask(int $mask): string
    {
        return base_convert(((2 ** 32) - (2 ** (32 - $mask))), 10, 16);
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

    /**
     * @return string|null
     */
    private function getCountry(): ?string
    {
        if (in_array($this->getRdap()->getProtocol(), [$this->getRdap()::IPV4, $this->getRdap()::IPV6], true)) {
            $this->getResponse()->getCountry();

        }
        return null;
    }
}
