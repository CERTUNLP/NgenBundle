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
use CertUnlp\NgenBundle\Entity\Playbook\Task;

/**
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class Phase extends PlaybookElement
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @var Playbook
     * @CustomAssert\EntityNotActive()
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Playbook",inversedBy="phases")
     * @ORM\JoinColumn(name="playbook", referencedColumnName="id")
     * @JMS\Groups({"read","write","fundamental"})
     * @JMS\Expose
     */
    private $playbook;

    /**
     * @var Collection | Task[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Task", mappedBy="phase", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @JMS\Expose
     */
    private $tasks;
    
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
    public function setPlaybook(Playbook $playbook): Phase
    {
        $this->playbook = $playbook;
        return $this;
    }

    /**
     * @return Task[]|Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Task[]|Collection $tasks
     * @return Phase
     */
    public function setTasks(Collection $tasks): self
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * @param Task $task
     * @return $this
    */
    public function addTask(Task $task): self
    {
        if ($task && !$this->tasks->contains($task)) {
            $task->setPhase($this);
            $this->tasks->add($task);
        }
        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);

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
