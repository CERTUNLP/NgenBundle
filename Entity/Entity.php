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

use CertUnlp\NgenBundle\Model\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\MappedSuperclass()
 * @JMS\ExclusionPolicy("all")
 * @Gedmo\SoftDeleteable()
 */
abstract class Entity implements EntityInterface
{
    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $createdAt = null;
    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $updatedAt = null;
    /**
     * @var int|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
     * @Gedmo\Blameable(on="create")
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     */
    protected $createdBy = null;
    /**
     * @var DateTime|null
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $deletedAt = null;

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime|null $deletedAt
     * @return Entity
     */
    public function setDeletedAt(?DateTime $deletedAt): Entity
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }


    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Entity
     */
    public function setCreatedAt(DateTime $createdAt): Entity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return Entity
     */
    public function setUpdatedAt(DateTime $updatedAt): Entity
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    /**
     * @param int|null $createdBy
     * @return Entity
     */
    public function setCreatedBy(?int $createdBy): Entity
    {
        $this->createdBy = $createdBy;
        return $this;
    }


}
