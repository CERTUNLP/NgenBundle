<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Service\Rdap;

use Closure;
use RuntimeException;

/**
 * Description of RdapResultWrapper
 *
 * @author dam
 */
class RdapResultWrapper
{
    /**
     * @var Entity[]
     */
    private $entities;
    private $rdap_json_object;


    public function __construct(string $rdap_json_response)
    {

        $this->rdap_json_object = json_decode($rdap_json_response, false);
        if ($this->getRateLimitNotice()) {
            throw new RuntimeException($this->getRateLimitNotice()[0]);
        }
        $entities = [];
        if (isset($this->rdap_json_object->entities)) {
            foreach ($this->rdap_json_object->entities as $entity) {
                $entities[] = new Entity($entity);
            }
        }
        $this->entities = new Entities($entities);
    }

    /**
     * @return string
     */
    public function getRateLimitNotice(): string
    {
        return $this->getNoticeElement('Rate Limit Notice');
    }

    /**
     * @param string $element
     * @return string
     */
    public function getNoticeElement(string $element): string
    {
        foreach ($this->getNotices() as $notice) {
            if ($notice->title === $element) {
                return $notice->description;
            }
        }
        return '';
    }

    /**
     * @return array
     */
    public function getNotices(): array
    {
        return $this->rdap_json_object->notices;
    }

    /**
     * @return int
     */
    public function getCidr(): int
    {
        return isset($this->rdap_json_object->cidr0_cidrs) ? $this->rdap_json_object->cidr0_cidrs[0]->length : 0;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->rdap_json_object->name ?? '';
    }

    /**
     * @return string
     */
    public function getObjectClassName(): string
    {
        return $this->rdap_json_object->objectClassName ?? '';
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->rdap_json_object->handle ?? '';
    }

    /**
     * @return string
     */
    public function getStartAddress(): string
    {
        return $this->rdap_json_object->startAddress ?? '';
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->rdap_json_object->country ?? '';
    }

    /**
     * @return string
     */
    public function getEndAddress(): string
    {
        return $this->rdap_json_object->endAddress ?? '';
    }

    /**
     * @return string
     */
    public function getIpVersion(): string
    {
        return $this->rdap_json_object->ipVersion ?? '';
    }

    /**
     * @return string
     */
    public function getParentHandle(): string
    {
        return $this->rdap_json_object->parentHandle ?? '';
    }

    /**
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->rdap_json_object->remarks ?? '';
    }

    /**
     * @return string
     */
    public function getLastChanged(): string
    {
        return $this->getEventElement('last changed');
    }


    /**
     * @param string $element
     * @return string
     */
    public function getEventElement(string $element): string
    {
        foreach ($this->getEvents() as $event) {
            if ($event->eventAction === $element) {
                return $event->eventDate;
            }
        }
        return '';
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->rdap_json_object->events ?? [];
    }


    /**
     * @return string
     */
    public function getRegistration(): string
    {
        return $this->getEventElement('registration');
    }

    /**
     * @return array
     */
    public function getAbuseEmails(): array
    {
        return $this->entities->getAbuseEmails();
    }

    /**
     * @param bool $recrusive
     * @param Closure|null $callback
     * @return array|Entity[]
     */
    public function getEntities(bool $recrusive = false, Closure $callback = null): array
    {
        return $this->entities->getEntities($recrusive, $callback);
    }

    /**
     * @return array|Entity[]
     */
    public function getAbuseEntities(): array
    {
        return $this->entities->getAbuseEntities();
    }

    /**
     * @return Entity|null
     */
    public function getAbuseEntity(): ?Entity
    {
        return $this->entities->getAbuseEntity();
    }

}
