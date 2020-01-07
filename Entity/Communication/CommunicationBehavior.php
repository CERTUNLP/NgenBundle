<?php

namespace CertUnlp\NgenBundle\Entity\Communication;

use CertUnlp\NgenBundle\Entity\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;



/**
 * CommunicationBehavior
 *
 * @author einar
 * @ORM\Entity()
 * @ORM\Table(name="communication_behavior")
 */

class CommunicationBehavior extends Entity
{
 /**
 * @var string
 *
 * @ORM\Column(name="name", type="string", length=100)
 * @JMS\Expose
 * @JMS\Groups({"api_input"})
 * @Gedmo\Translatable
 */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * */
    private $slug;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;
    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(name="inNew", type="string", columnDefinition="ENUM('manual','file','data', 'all')"))
     * @JMS\Expose
     */
    private $in_new='manual';

    /**
     * @var string
     * @ORM\Column(name="inOpen", type="string", columnDefinition="ENUM('manual','file','data', 'all')"))
     * @JMS\Expose
     */
    private $in_open='all';

    /**
     * @var string
     * @ORM\Column(name="inUpdate", type="string", columnDefinition="ENUM('manual','file','data', 'all')"))
     * @JMS\Expose
     */
    private $in_update='all';


    /**
     * @var string
     * @ORM\Column(name="inSummary", type="string", columnDefinition="ENUM('manual','file','data', 'all')"))
     * @JMS\Expose
     */
    private $in_summary='manual';

    /**
     * @var string
     * @ORM\Column(name="whenToUpdate", type="string", columnDefinition="ENUM('daily','live', 'manual')")
     * @JMS\Expose
     */
    private $when_to_update= "manual";

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getInNew(): string
    {
        return $this->in_new;
    }

    /**
     * @param string $in_new
     */
    public function setInNew(string $in_new): void
    {
        $this->in_new = $in_new;
    }

    /**
     * @return string
     */
    public function getInOpen(): string
    {
        return $this->in_open;
    }

    /**
     * @param string $in_open
     */
    public function setInOpen(string $in_open): void
    {
        $this->in_open = $in_open;
    }

    /**
     * @return string
     */
    public function getInUpdate(): string
    {
        return $this->in_update;
    }

    /**
     * @param string $in_update
     */
    public function setInUpdate(string $in_update): void
    {
        $this->in_update = $in_update;
    }

    /**
     * @return string
     */
    public function getInSummary(): string
    {
        return $this->in_summary;
    }

    /**
     * @param string $in_summary
     */
    public function setInSummary(string $in_summary): void
    {
        $this->in_summary = $in_summary;
    }

    /**
     * @return string
     */
    public function getWhenToUpdate(): string
    {
        return $this->when_to_update;
    }

    /**
     * @param string $when_to_update
     */
    public function setWhenToUpdate(string $when_to_update): void
    {
        $this->when_to_update = $when_to_update;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'th';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'primary';
    }
}
