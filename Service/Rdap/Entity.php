<?php

namespace CertUnlp\NgenBundle\Service\Rdap;

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

    public function __construct(object $entity_object = null)
    {
        $entities = [];
        $this->object = $entity_object;
        if (isset($this->object->entities)) {
            foreach ($this->object->entities as $entity) {

                $entities[] = new Entity($entity);
            }
        }
        $this->entities = new Entities($entities);
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
                $this->getLinks(), static function ($e) {
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
     * @return string
     */
    public function getHandle(): string
    {
        return $this->object->handle ?? '';
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
     * @return array | Entity[]
     */
    public function getEntities(): array
    {
//        $entities = [];
//        if ($callback) {
//            $entities[] = $callback($this);
//        } else {
//            $entities[] = $this;
//        }
//        foreach ($this->entities as $entity) {
//            if ($callback) {
//                $entities[] = $callback($entity);
//            } else {
//                $entities[] = $entity;
//            }
//
//            $entities += $entity->getEntities($callback);
//        }
//        return new Entities($entities);
        return $this->entities;
    }

}
