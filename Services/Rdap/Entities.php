<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

use CertUnlp\NgenBundle\Services\Rdap\Entity;

/**
 * Description of Entities
 *
 * @author dam
 */
class Entities {

    public function __construct($entities) {
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

        return $entities;
    }

    public function getEntities() {
        return $this->entities;
    }

}
