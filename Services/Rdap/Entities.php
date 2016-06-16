<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

use CertUnlp\NgenBundle\Services\Rdap\Entity;
use RecursiveArrayIterator;

/**
 * Description of Entities
 *
 * @author dam
 */
class Entities {

    public function __construct($entities = []) {
        $this->entities = [];
        foreach ($entities as $entity) {

            $this->entities[] = new Entity($entity);
        }
    }

    public function getByRole($roles) {
        $entities = [];
        foreach ($this->getEntities() as $entity) {
            foreach ($roles as $role) {
                if (in_array($role, $entity->getRoles())) {
                    $entities[] = $entity;
                }
            }
        }

        return $entities;
    }

    public function getOneByRole($roles) {
        $entities = $this->getByRole($roles);

        if ($entities) {
            return $entities[0];
        }

        return null;
    }

    public function getAbuseEntities() {

        $abuse_entities = $this->getByRole(['abuse']);
        $extra_entities = $this->getByRole(['noc', 'technical']);

        return $abuse_entities ? $abuse_entities : $extra_entities;
    }

    public function getAbuseEntity() {
        $abuse_entities = $this->getAbuseEntities();
        return $abuse_entities ? $abuse_entities[0] : [];
    }

    public function getAbuseEmails() {
        $abuse_emails = [];
        $abuse_entities = $this->getAbuseEntities();

        foreach ($abuse_entities as $abuse_entity) {
            $abuse_emails = array_merge($abuse_emails, $abuse_entity->getEmails());
        }

        return $abuse_emails;
    }

    public function getEntities($callback = null) {

        $entities = [];
        foreach ($this->entities as $entity) {
            $entities = array_merge($entities, $entity->getEntities());
        }
        return $entities;
    }

}
