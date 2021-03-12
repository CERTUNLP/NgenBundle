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
use DateTime;
use CertUnlp\NgenBundle\Entity\Playboook\Phase;
use CertUnlp\NgenBundle\Entity\Playbook\PlaybookElement;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Playbook\TaskRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Task extends PlaybookElement
{
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="suggested_time", type="time")
     * @JMS\Type("DateTime<'H:i:s'>")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    protected $suggested_time;

    /**
     * @var Phase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Phase", inversedBy="tasks")
     * @ORM\JoinColumn(name="phase", referencedColumnName="id")
     * @JMS\Groups({"read","write","fundamental"})
     * @JMS\Expose
     */
    private $phase;

    /**
     * @return Phase
     */
    public function getPhase(): ?Object 
    {
        return $this->phase;
    }

    /**
     * @param Phase $phase
     * @return Task
     */
    public function setPhase(Object $phase): Task
    {
        $this->phase = $phase;
        return $this;
    }

    /**
     */
    public function getSuggestedTime(): ?DateTime 
    {
        return $this->suggested_time;
    }

    /**
     * @param DateTime|null $suggested_time
     * @return Task
     */
    public function setSuggestedTime(DateTime $suggested_time = null): Task
    {
        $this->suggested_time = $suggested_time;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataIdentificationArray(): array
    {
        return ['phase' => $this->getPhase()->getId()];
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return true;
    }
}
