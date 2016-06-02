<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

use CertUnlp\NgenBundle\Services\Rdap\Entities;
use Exception;

/**
 * Description of RdapResultWrapper
 *
 * @author dam
 */
class RdapResultWrapper {

    public function __construct($rdap_json_response) {
        $this->rdap_json_object = json_decode($rdap_json_response);
        if ($this->getRateLimitNotice()) {
            throw new Exception($this->getRateLimitNotice()[0]);
        }

        $this->entities = new Entities($this->rdap_json_object->entities);
    }

    public function getName() {
        return $this->rdap_json_object->name;
    }

    public function getObjectClassName() {
        return $this->rdap_json_object->objectClassName;
    }

    public function getHandle() {
        return $this->rdap_json_object->handle;
    }

    public function getStartAddress() {
        return $this->rdap_json_object->startAddress;
    }

    public function getEndAddress() {
        return $this->rdap_json_object->endAddress;
    }

    public function getIpVersion() {
        return $this->rdap_json_object->ipVersion;
    }

    public function getParentHandle() {
        return $this->rdap_json_object->parentHandle;
    }

    public function getRemarks() {
        return $this->rdap_json_object->remarks;
    }

    public function getEvents() {
        return $this->rdap_json_object->events;
    }

    public function getEventElement($element) {
        foreach ($this->getEvents() as $event) {
            if ($event->eventAction == $element) {
                return $event->eventDate;
            }
        }
        return null;
    }

    public function getLastChanged() {
        return $this->getEventElement('last changed');
    }

    public function getRegistration() {
        return $this->getEventElement('registration');
    }

    public function getEntities() {

        return $this->entities;
    }

    public function getNotices() {
        return $this->rdap_json_object->notices;
    }

    public function getRateLimitNotice() {
        return $this->getNoticeElement('Rate Limit Notice');
    }

    public function getNoticeElement($element) {
        foreach ($this->getNotices() as $notice) {
            if ($notice->title == $element) {
                return $notice->description;
            }
        }
        return null;
    }

    public function getEmail() {
        return $this->getVcardElement('email');
    }

}
