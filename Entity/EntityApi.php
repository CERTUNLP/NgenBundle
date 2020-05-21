<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\MappedSuperclass()
 */
abstract class EntityApi extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $slug;
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    private $active = true;

    /**
     * @return Entity
     */
    public function activate(): Entity
    {
        $this->setActive(true);
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Entity
     */
    public function setActive(bool $active): Entity
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Entity
     */
    public function desactivate(): Entity
    {
        $this->setActive(false);
        return $this;
    }

    /**
     * @return array
     */
    public function getEntityIdentificationArray(): array
    {
        return [$this->getIdentificatorString() => $this->getId()];
    }

    /**
     * @return string
     */
    abstract public function getIdentificatorString(): string;

    /**
     * @return int|string|null
     */
    public function getId()
    {
        $identificator_string = $this->getIdentificatorString();
        return $this->$identificator_string;
    }

    /**
     * @param int|string|null $id
     * @return Entity
     */
    public function setId($id): Entity
    {
        $identificator_string = $this->getIdentificatorString();
        $this->$identificator_string = $id;
        return $this;
    }

}
