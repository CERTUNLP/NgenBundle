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

use CertUnlp\NgenBundle\Model\EntityApiInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\MappedSuperclass()
 * @JMS\ExclusionPolicy("all")
 */
abstract class EntityApi extends Entity implements EntityApiInterface
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
     * @JMS\Expose()
     * @JMS\Groups({"read","write","list"})
     */
    protected $active = true;

    /**
     * @return EntityApiInterface
     */
    public function activate(): EntityApiInterface
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
     * @return EntityApiInterface
     */
    public function deactivate(): EntityApiInterface
    {
        $this->setActive(false);
        return $this;
    }

    /**
     * @return array
     */
    public function getIdentificationArray(): array
    {
        return [$this->getIdentificationString() => $this->getId()];
    }

    /**
     * @return string
     */
    abstract public function getIdentificationString(): string;

    /**
     * @return int|string|null
     */
    public function getId()
    {
        $identification_string = $this->getIdentificationString();
        return $this->$identification_string;
    }

    /**
     * @param int|string|null $id
     * @return Entity
     */
    public function setId($id): Entity
    {
        $identification_string = $this->getIdentificationString();
        $this->$identification_string = $id;
        return $this;
    }

    /**
     * @return array
     */
    abstract public function getDataIdentificationArray(): array;

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return true;
    }
}
