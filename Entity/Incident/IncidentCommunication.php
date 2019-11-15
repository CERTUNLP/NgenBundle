<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use DateTime;
/**
 * IncidentCommunication
 *
 * @ORM\Table(name="incident_communication")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"telegram" = "TelegramMessage", "threema" = "ThreemaMessage", "message"="Message"})
 */

class IncidentCommunication
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $updatedAt;
    /**
     * @var array|null
     *
     * @ORM\Column(name="data", type="json_array")
     */
    private $data;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Contact\Contact",mappedBy="user",cascade={"persist"},orphanRemoval=true)
     */
    private $destinations;


    /**
     * @var Incident
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="communicationHistory")
     *
     * */
    private $incident;

    /**
     * @var IncidentDetected
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentDetected", inversedBy="communicationHistory")
     *
     * */
    private $ltd;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->destinations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return Collection
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
    }

    /**
     * @param Collection $destinations
     */
    public function setDestinations(Collection $destinations): void
    {
        $this->destinations = $destinations;
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
     */
    public function setIncident(Incident $incident): void
    {
        $this->incident = $incident;
    }

    /**
     * @return IncidentDetected
     */
    public function getLtd(): IncidentDetected
    {
        return $this->ltd;
    }

    /**
     * @param IncidentDetected $ltd
     */
    public function setLtd(IncidentDetected $ltd): void
    {
        $this->ltd = $ltd;
    }



    }

