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
        $this->entities = [];
//        var_dump("$$$$$$$$$$$$$$$$$", $entity->entities);
//        var_dump("$$$$$$$",$this);die;
//        die;
        if (isset($this->object->entities)) {
            foreach ($this->object->entities as $entity) {
                $this->entities[] = new Entity($entity);
            }
        }
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

    public function getEntities() {
        
        return $this->entities;
    }

}
