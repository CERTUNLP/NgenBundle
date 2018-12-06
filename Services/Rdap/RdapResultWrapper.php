<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

use Exception;

/**
 * Description of RdapResultWrapper
 *
 * @author dam
 */
class RdapResultWrapper
{
    private $entities;
    private $rdap_json_object;

    /**
     * RdapResultWrapper constructor.
     * @param $rdap_json_response
     * @throws Exception
     */
    public function __construct(string $rdap_json_response)
    {

        $this->rdap_json_object = json_decode($rdap_json_response);
        if ($this->getRateLimitNotice()) {
            throw new \RuntimeException($this->getRateLimitNotice()[0]);
        }

        $this->entities = new Entities($this->rdap_json_object->entities ?? []);
    }

    public function getRateLimitNotice(): string
    {
        return $this->getNoticeElement('Rate Limit Notice');
    }

    public function getNoticeElement(string $element): string
    {
        foreach ($this->getNotices() as $notice) {
            if ($notice->title === $element) {
                return $notice->description;
            }
        }
        return '';
    }

    public function getNotices(): array
    {
        return $this->rdap_json_object->notices;
    }

    public function getName(): string
    {
        return $this->rdap_json_object->name ?? '';
    }

    public function getObjectClassName(): string
    {
        return $this->rdap_json_object->objectClassName ?? '';
    }

    public function getHandle(): string
    {
        return $this->rdap_json_object->handle ?? '';
    }

    public function getStartAddress(): string
    {
        return $this->rdap_json_object->startAddress ?? '';
    }

    public function getCountry(): string
    {
        return $this->rdap_json_object->country ?? '';
    }

    public function getEndAddress(): string
    {
        return $this->rdap_json_object->endAddress ?? '';
    }

    public function getIpVersion(): string
    {
        return $this->rdap_json_object->ipVersion ?? '';
    }

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

    public function getLastChanged(): string
    {
        return $this->getEventElement('last changed');
    }

    /**
     * @param string $element
     * @return string |null
     */
    public function getEventElement(string $element): string
    {
        foreach ($this->getEvents() as $event) {
            if ($event->eventAction === $element) {
                return $event->eventDate;
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->rdap_json_object->events ?? [];
    }

    /**
     * @return string |null
     */
    public function getRegistration(): string
    {
        return $this->getEventElement('registration');
    }

    public function getAbuseEmails(): array
    {
        return $this->getEntities()->getAbuseEmails();
    }

    public function getEntities(): Entities
    {

        return $this->entities;
    }

    /**
     * @return array|Entity[]
     */
    public function getAbuseEntities(): array
    {
        return $this->getEntities()->getAbuseEntities();
    }

    public function getAbuseEntity(): ?Entity
    {
        return $this->getEntities()->getAbuseEntity();
    }

}
