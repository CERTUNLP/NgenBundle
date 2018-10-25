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
class Entity
{

    private $object;
    private $entities;

    public function __construct($entity_object)
    {
        $this->object = $entity_object;
        if (isset($this->object->entities)) {
            foreach ($this->object->entities as $entity) {

                $this->entities[] = new Entity($entity);
            }
        } else {
            $this->entities = [];
        }
    }

    public function __toString()
    {
        return $this->object->name . "( " . $this->object->handle . " )";
    }

    public function getSelfLink()
    {
        if ($this->getLinks()) {
            return array_filter(
                $this->getLinks(), function ($e) {
                return $e->rel == "self";
            }
            )[0]->href;
        }
        return [];
    }

    public function getLinks()
    {
        if (isset($this->object->links)) {
            return $this->object->links;
        }
        return [];
    }

    public function getRoles()
    {
        if (isset($this->object->roles)) {
            return $this->object->roles;
        }
        return [];
    }

    public function getRolesAsString()
    {
        $string = "";
        if (isset($this->object->roles)) {
            foreach ($this->object->roles as $role) {
                $string .= "$role ";
            }
        }
        return $string;
    }

    public function getHandle()
    {
        if (isset($this->object->handle)) {
            return $this->object->handle;
        }
        return [];
    }

    public function getEmails()
    {
        return $this->getVcardElement('email');
    }

    public function getVcardElement($element)
    {
        $elements = [];
        foreach ($this->getVcard() as $vcard) {
            if ($vcard[0] == $element) {
                $elements[] = $vcard[sizeof($vcard) - 1];
            }
        }
        return $elements;
    }

    public function getVcard()
    {
        if (isset($this->object->vcardArray)) {
            return $this->object->vcardArray[1];
        }
        return [];
    }

    public function getName()
    {
        return $this->getVcardElement('fn')[0];
    }

    public function getOrganization()
    {
        return $this->getVcardElement('org');
    }

    public function getPhone()
    {
        return $this->getVcardElement('tel');
    }

    public function getEntities($callback = '')
    {
        $entities = [];
        if ($callback) {
            $entities[] = $callback($this);
        } else {
            $entities[] = $this;
        }
        foreach ($this->entities as $entity) {
            $entities = array_merge($entities, $entity->getEntities($callback));
        }
        return $entities;
    }

}
