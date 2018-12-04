<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

//use CertUnlp\NgenBundle\Services\Rdap\Entity;
use stdClass;

/**
 * Description of Entity
 *
 * @author dam
 */
class Entity
{
    /**
     * @var stdClass
     */
    private $object;
    /**
     * @var array | Entity[]
     */
    private $entities;

    public function __construct(stdClass $entity_object)
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

    /**
     * @return stdClass
     */
    public function getObject(): stdClass
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     * @return Entity
     */
    public function setObject(stdClass $object): Entity
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->object->name . '( ' . $this->object->handle . ' )';
    }

    public function getSelfLink(): string
    {
        if ($this->getLinks()) {
            return array_filter(
                $this->getLinks(), function ($e) {
                return $e->rel === 'self';
            }
            )[0]->href;
        }
        return '';
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->object->links ?? [];
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->object->roles ?? [];
    }

    /**
     * @return string
     */
    public function getRolesAsString(): string
    {
        $string = '';
        if (isset($this->object->roles)) {
            foreach ($this->object->roles as $role) {
                $string .= "$role ";
            }
        }
        return $string;
    }

    /**
     * @return array
     */
    public function getHandle(): array
    {
        return $this->object->handle ?? [];
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return $this->getVcardElement('email');
    }

    /**
     * @param string $element
     * @return array
     */
    public function getVcardElement(string $element): array
    {
        $elements = [];
        foreach ($this->getVcard() as $vcard) {
            if ($vcard[0] === $element) {
                $elements[] = $vcard[count($vcard) - 1];
            }
        }
        return $elements;
    }

    /**
     * @return array
     */
    public function getVcard(): array
    {
        if (isset($this->object->vcardArray)) {
            return $this->object->vcardArray[1];
        }
        return [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getVcardElement('fn')[0];
    }

    /**
     * @return array
     */
    public function getOrganization(): array
    {
        return $this->getVcardElement('org');
    }

    /**
     * @return array
     */
    public function getPhone(): array
    {
        return $this->getVcardElement('tel');
    }

    /**
     * @param \Closure|null $callback
     * @return array
     */
    public function getEntities(\Closure $callback = null): array
    {
        $entities = [];
        if ($callback) {
            $entities[] = $callback($this);
        } else {
            $entities[] = $this;
        }
        foreach ($this->entities as $entity) {
            $entities[] = $entity->getEntities($callback);
        }
        array_merge($entities);
        return $entities;
    }

}
