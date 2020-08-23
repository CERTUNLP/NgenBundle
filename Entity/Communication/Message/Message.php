<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication\Message;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Communication\Message\MessageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"telegram" = "MessageTelegram", "email" = "MessageEmail", "message"="Message"})
 * @ORM\HasLifecycleCallbacks
 */
abstract class Message extends Entity
{
    /**
     * @var int|null
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $data = [];

    /**
     * @var array
     * @ORM\Column(type="json",nullable=true)
     */
    private $response = [];

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $pending = true;

    /**
     * @var Incident
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="messages")
     */
    private $incident = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Message
     */
    public function setId(?int $id): Message
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Message
     */
    public function setData(array $data): Message
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param array $response
     * @return Message
     */
    public function setResponse(array $response): Message
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @param array $response
     * @return Message
     */
    public function addResponse(array $response): Message
    {
        $date = new DateTime();
        $this->response[$date->getTimestamp()] = $response;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->pending;
    }

    /**
     * @param bool $pending
     * @return Message
     */
    public function setPending(bool $pending): Message
    {
        $this->pending = $pending;
        return $this;
    }

    /**
     * @return Incident
     */
    public function getIncident(): Incident
    {
        return $this->incident;
    }

    /**
     * @param Incident $incident
     * @return Message
     */
    public function setIncident(Incident $incident): Message
    {
        $this->incident = $incident;
        return $this;
    }


}
