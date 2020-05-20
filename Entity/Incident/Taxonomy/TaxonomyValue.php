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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * TaxonomyValue
 * @ORM\Entity()
 * @ORM\Table(name="taxonomy_value")
 */
class TaxonomyValue extends EntityApi
{
    /**
     * @var string|null
     * @ORM\Id
     * @Gedmo\Slug(fields={"value"}, separator="_")
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
     * @ORM\Column(name="description", type="string", length=1024)
     */
    private $description;
    /**
     * @var string|null
     *
     * @ORM\Column(name="expanded", type="string", length=255)
     */
    private $expanded;
    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, unique=true)
     */
    private $value;
    /**
     * @var TaxonomyPredicate|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate",inversedBy="values")
     * @ORM\JoinColumn(name="taxonomyPredicate", referencedColumnName="slug",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     **/

    private $predicate;
    /**
     * @var int|null
     *
     * @ORM\Column(name="version", type="integer")
     */
    private $version;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->getSlug();
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

    public function __toString(): string
    {
        return $this->getPredicate()->getExpanded() . ' -> ' . $this->getExpanded();
    }

    /**
     * Get predicate
     *
     * @return TaxonomyPredicate
     */
    public function getPredicate(): TaxonomyPredicate
    {
        return $this->predicate;
    }

    /**
     * Set predicate
     *
     * @param TaxonomyPredicate $predicate
     *
     * @return TaxonomyValue
     */
    public function setPredicate(TaxonomyPredicate $predicate): self
    {
        $this->predicate = $predicate;

        return $this;
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
     * @return TaxonomyValue
     */
    public function setExpanded(string $expanded): TaxonomyValue
    {
        $this->expanded = $expanded;

        return $this;
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
     * Get report
     *
     * @return IncidentReport
     */
    public function getReport(): IncidentReport
    {
        $reporte = new IncidentReport();
        $reporte->setProblem($this->getPredicate()->getExpanded() . ': ' . $this->getPredicate()->getDescription());
        $reporte->setDerivatedProblem($this->getExpanded() . ': ' . $this->getDescription());
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
     * @return TaxonomyValue
     */
    public function setDescription(string $description): TaxonomyValue
    {
        $this->description = $description;

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
     * @return TaxonomyValue
     */
    public function setValue(string $value): TaxonomyValue
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
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
     * @return TaxonomyValue
     */
    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate(): self
    {
        return $this->setUpdatedAt(new DateTime('now'));
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

    /**
     * @return string
     */
    public function getIdentificatorString(): string
    {
        return 'slug';
    }
}

