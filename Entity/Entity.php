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

use Closure;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
abstract class Entity
{

//    /**
//     * @var integer|null
//     *
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\GeneratedValue(strategy="AUTO")
//     * @JMS\Expose
//     */
//    protected $id;
//    /**
//     * @var DateTime|null
//     * @Gedmo\Timestampable(on="create")
//     * @ORM\Column(name="created_at", type="datetime", nullable=true)
//     * @JMS\Expose
//     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
//     */
//    protected $createdAt;
//    /**
//     * @var DateTime|null
//     * @Gedmo\Timestampable(on="update")
//     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
//     * @JMS\Expose
//     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
//     */
//    protected $updatedAt;
//    /**
//     * @var DateTime|null
//     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
//     * @Gedmo\Blameable(on="create")
//     */
//    protected $createdBy;
//    /**
//     * @var boolean
//     *
//     * @ORM\Column(name="is_active", type="boolean")
//     * @JMS\Expose
//     */
//    protected $isActive = true;

    /**
     * @return string
     */
    abstract public function getIcon(): string;


    /**
     * @return string
     */
    abstract public function getColor(): string;
//
//    /**
//     * @return int|null
//     */
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    /**
//     * @param int|null $id
//     * @return Entity
//     */
//    public function setId(?int $id): Entity
//    {
//        $this->id = $id;
//        return $this;
//    }
//
//    /**
//     * @return DateTime|null
//     */
//    public function getCreatedAt(): ?DateTime
//    {
//        return $this->createdAt;
//    }
//
//    /**
//     * @param DateTime|null $createdAt
//     * @return Entity
//     */
//    public function setCreatedAt(?DateTime $createdAt): Entity
//    {
//        $this->createdAt = $createdAt;
//        return $this;
//    }
//
//    /**
//     * @return DateTime|null
//     */
//    public function getUpdatedAt(): ?DateTime
//    {
//        return $this->updatedAt;
//    }
//
//    /**
//     * @param DateTime|null $updatedAt
//     * @return Entity
//     */
//    public function setUpdatedAt(?DateTime $updatedAt): Entity
//    {
//        $this->updatedAt = $updatedAt;
//        return $this;
//    }
//
//    /**
//     * @return DateTime|null
//     */
//    public function getCreatedBy(): ?DateTime
//    {
//        return $this->createdBy;
//    }
//
//    /**
//     * @param DateTime|null $createdBy
//     * @return Entity
//     */
//    public function setCreatedBy(?DateTime $createdBy): Entity
//    {
//        $this->createdBy = $createdBy;
//        return $this;
//    }
//
//    /**
//     * @return bool
//     */
//    public function isActive(): bool
//    {
//        return $this->isActive;
//    }
//
//    /**
//     * @param bool $isActive
//     * @return Entity
//     */
//    public function setIsActive(bool $isActive): Entity
//    {
//        $this->isActive = $isActive;
//        return $this;
//    }
    /**
     * @param Collection $collection
     * @param Closure $callback
     * @return array
     */
    public function getRatio(Collection $collection, Closure $callback): array
    {
        $ratio = [];
        foreach ($collection as $colectee) {
            if (isset($ratio[$callback($colectee)])) {
                $ratio[$callback($colectee)]++;
            } else {
                $ratio[$callback($colectee)] = 1;
            }
        }

        $percentages = [];
        foreach ($ratio as $key => $value) {
            $percentages[] = [$key, $value];
        }

        return $percentages;
    }


}
