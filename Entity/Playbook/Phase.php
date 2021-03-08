<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Description of Playbook
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Entity\Playbook;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

use CertUnlp\NgenBundle\Entity\Playbook\PlaybookElement;
use CertUnlp\NgenBundle\Entity\Playbook\Playbook;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Playbook\PhaseRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Phase extends PlaybookElement
{
    /**
     * @var Playbook
     * @CustomAssert\EntityNotActive()
     * @JMS\Expose
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Playbook",inversedBy="phases")
     * @ORM\JoinColumn(name="playbook", referencedColumnName="id")
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $playbook;

    /**
     * @var Collection | PlaybookElement[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\PlaybookElement", mappedBy="parent", fetch="EXTRA_LAZY")
     * @JMS\Expose
     */
    private $children;
    
    /**
     */
    public function getPlaybook(): ?Playbook 
    {
        return $this->playbook;
    }

    /**
     * @param Playbook|null $playbook
     * @return Phase
     */
    public function setPlaybook(Playbook $playbook = null): Phase
    {
        $this->playbook = $playbook;
        return $this;
    }

    /**
     * @return Phase[]|Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Phase[]|Collection $children
     * @return Playbook
     */
    public function setPhase(Collection $children): self
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataIdentificationArray(): array
    {
        return ['playbook' => $this->getPlaybook()->getId()];
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return true;
    }
}
