<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

//use CertUnlp\NgenBundle\Services\Rdap\Entity;

/**
 * Description of Entity
 *
 * @author dam
 */
class Entity {

    public function __construct($entity_object) {
        $this->object = $entity_object;
        if (isset($this->object->entities)) {
            foreach ($this->object->entities as $entity) {

                $this->entities[] = new Entity($entity);
            }
        } else {
            $this->entities = [];
        }
    }

    public function __toString() {
        return $this->object->handle . "(" . $this->getRolesAsString() . ")";
    }

    public function getVcard() {
        if (isset($this->object->vcardArray)) {
            return $this->object->vcardArray[1];
        }
    }

    public function getRoles() {
        if (isset($this->object->roles)) {
            return $this->object->roles;
        }
        return [];
    }

    public function getRolesAsString() {
        $string = "";
        if (isset($this->object->roles)) {
            foreach ($this->object->roles as $role) {
                $string .= "$role ";
            }
        }
        return $string;
    }

    public function getHandle() {
        if (isset($this->object->handle)) {
            return $this->object->handle;
        }
    }

    public function getVcardElement($element) {
        foreach ($this->getVcard() as $vcard) {
            if ($vcard[0] == $element) {
                return $vcard[sizeof($vcard) - 1];
            }
        }
        return null;
    }

    public function getEmail() {
        return $this->getVcardElement('email');
    }

    public function getName() {
        return $this->getVcardElement('fn');
    }

    public function getOrganization() {
        return $this->getVcardElement('org');
    }

    public function getPhone() {
        return $this->getVcardElement('tel');
    }

    public function getEntities($callback = null) {
        $entities = [];
        if ($callback) {
            $entities[] = $callback($this);
        } else {
            $entities[] = $this;
        }
        foreach ($this->entities as $entity) {
            if ($callback) {
                $entities[] = $callback($entity);
            } else {
                $entities[] = $entity;
            }

            $entities += $entity->getEntities($callback);
        }
        return $entities;
    }

}
