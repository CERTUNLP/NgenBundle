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

use CertUnlp\NgenBundle\Entity\EntityApi;
use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * TaxonomyPredicate
 *
 * @author einar
 * @ORM\Entity()
 * @ORM\Table(name="taxonomy_predicate")
 */
class TaxonomyPredicate extends EntityApi
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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue",mappedBy="predicate")
     * @JMS\Exclude()
     */

    private $values;
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
     * Constructor
     */
    public function __construct()
    {
        $this->values = new ArrayCollection();
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
     * Get version
     *
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return taxonomyPredicate
     */
    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return taxonomyPredicate
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getExpanded();
    }

    /**
     * Get expanded
     *
     * @return string
     */
    public function getExpanded(): string
    {
        return $this->expanded;
    }

    /**
     * Set expanded
     *
     * @param string $expanded
     *
     * @return taxonomyPredicate
     */
    public function setExpanded(string $expanded): self
    {
        $this->expanded = $expanded;

        return $this;
    }

    /**
     * Get report
     *
     * @return IncidentReport
     */
    public function getReport(): IncidentReport
    {
        $reporte = new IncidentReport();
        $reporte->setProblem($this->getExpanded() . ': ' . $this->getDescription());
        return $reporte;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return taxonomyPredicate
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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


    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'th-large';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'primary';
    }

    /**
     * Get expanded
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getExpanded();
    }

    /**
     * @return string
     */
    public function getIdentificatorString(): string
    {
        return 'slug';
    }
}




