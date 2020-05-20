<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication\Message;

use CertUnlp\NgenBundle\Entity\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\MessageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"telegram" = "TelegramMessage", "threema" = "ThreemaMessage", "message"="Message"})
 * @ORM\HasLifecycleCallbacks
 */
abstract class Message extends Entity
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array|null
     *
     * @ORM\Column(name="data", type="json")
     */
    private $data;

    /**
     * @var array|null
     *
     * @ORM\Column(name="response", type="json",nullable=true)
     */

    private $response;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="pending", type="boolean", nullable=true)
     */
    private $pending;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incident_id", type="integer")
     */
    private $incidentId;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Message
     */
    public function setData(array $data): Message
    {
        $this->data = $data;

        return $this;
    }


    /**
     * Get response
     *
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Set response
     *
     * @param array $response
     * @return Message
     */
    public function setResponse(array $response): Message
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get pending
     *
     * @return boolean
     */
    public function getPending(): bool
    {
        return $this->pending;
    }

    /**
     * Set pending
     *
     * @param boolean $pending
     * @return Message
     */
    public function setPending(bool $pending): Message
    {
        $this->pending = $pending;

        return $this;
    }

    /**
     * Get incidentId
     *
     * @return integer
     */
    public function getIncidentId(): int
    {
        return $this->incidentId;
    }

    /**
     * Set incidentId
     *
     * @param integer $incidentId
     * @return Message
     */
    public function setIncidentId(int $incidentId): Message
    {
        $this->incidentId = $incidentId;

        return $this;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate(): void
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
            $this->setPending(true);
        }
    }

}
