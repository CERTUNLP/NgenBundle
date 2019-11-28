<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
namespace CertUnlp\NgenBundle\Entity\Incident\Taxonomy;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport;
use Doctrine\Common\Collections\Collection;
use DateTime;
/**
 * TaxonomyPredicate
 *
 * @author einar
 * @ORM\Entity()
 * @ORM\Table(name="taxonomy_predicate")
 */
class TaxonomyPredicate
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1024)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="expanded", type="string", length=255)
     */
    private $expanded;

    /**
     * @var int
     *
     * @ORM\Column(name="version", type="integer")
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, unique=true)
     */
    private $value;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;


     /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue",mappedBy="predicate")
     *  @JMS\Exclude()
     */

     private $values;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->values = new Collection();
    }

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"value"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * */
    private $slug;

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
     * Set description
     *
     * @param string $description
     *
     * @return taxonomyPredicate
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set expanded
     *
     * @param string $expanded
     *
     * @return taxonomyPredicate
     */
    public function setExpanded($expanded)
    {
        $this->expanded = $expanded;

        return $this;
    }

    /**
     * Get expanded
     *
     * @return string
     */
    public function getExpanded()
    {
        return $this->expanded;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return taxonomyPredicate
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return taxonomyPredicate
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return taxonomyPredicate
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate()
    {
        $this->setUpdatedAt(new DateTime('now'));
    }

    public function __toString()
    {
        return $this->getExpanded();
    }

    /**
     * Get report
     *
     * @param string $lang
     * @return IncidentReport
     */
    public function getReport(string $lang = null)
    {
        $reporte = new IncidentReport();
        $reporte->setProblem($this->getExpanded().': '.$this->getDescription());
        return $reporte;
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
     * @return Collection
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    /**
     * @param Collection $values
     */
    public function setValues(Collection $values): void
    {
        $this->values = $values;
    }


}




