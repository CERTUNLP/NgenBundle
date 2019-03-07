<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\MessageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"telegram" = "TelegramMessage", "threema" = "ThreemaMessage"})
 */

class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="json_array")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var array
     *
     * @ORM\Column(name="response", type="json_array",nullable=true)
     */

    private $response;

    /**
     * @var bool
     *
     * @ORM\Column(name="pending", type="boolean", nullable=true)
     */
    private $pending;

    /**
     * @var int
     *
     * @ORM\Column(name="incident_id", type="integer")
     */
    private $incidentId;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Message
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Message
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set response
     *
     * @param string $response
     * @return Message
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string 
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set pending
     *
     * @param boolean $pending
     * @return Message
     */
    public function setPending($pending)
    {
        $this->pending = $pending;

        return $this;
    }

    /**
     * Get pending
     *
     * @return boolean 
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * Set incidentId
     *
     * @param integer $incidentId
     * @return Message
     */
    public function setIncidentId($incidentId)
    {
        $this->incidentId = $incidentId;

        return $this;
    }

    /**
     * Get incidentId
     *
     * @return integer 
     */
    public function getIncidentId()
    {
        return $this->incidentId;
    }
    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate()
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
            $this->setPending(true);
        }
    }

    public function isTelegram(): bool
    {
        return false;
    }
    public function isThreema(): bool
    {
        return false;
    }
}
