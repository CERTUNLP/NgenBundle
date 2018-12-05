<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use CertUnlp\NgenBundle\Validator\Constraints as NetworkAssert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of InternalIncident
 *
 * @author dam
 *
 */
class InternalIncident
{
    /**
     * @var string
     *
     * @ORM\Column(name="host_address", type="string", length=20)
     * @NetworkAssert\Ip
     * @NetworkAssert\ValidNetwork
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $ip;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"ip"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    protected $slug;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\NetworkInterface", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkAdmin", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network_admin;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkEntity", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network_entity;

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Incident
     */
    public function setHostAddress($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get network
     *
     * @return \CertUnlp\NgenBundle\Model\NetworkInterface}
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null)
    {
        $this->network = $network;
        $this->setNetworkAdmin($network->getNetworkAdmin());
        $this->setNetworkEntity($network->getNetworkEntity());

        return $this;
    }

    /**
     * Get networkEntity
     *
     * @return NetworkEntity
     */
    public function getNetworkEntity()
    {
        return $this->network_entity;
    }

    /**
     * Set networkEntity
     *
     * @param NetworkEntity $networkEntity
     *
     * @return InternalIncident
     */
    public function setNetworkEntity(NetworkEntity $networkEntity = null)
    {
        $this->network_entity = $networkEntity;

        return $this;
    }

    public function getEmails()
    {
        return $this->getNetworkAdmin()->getEmails();
    }

    /**
     * Get networkAdmin
     *
     * @return NetworkAdmin
     */
    public function getNetworkAdmin()
    {
        return $this->network_admin;
    }

    /**
     * Set networkAdmin
     *
     * @param NetworkAdmin $networkAdmin
     *
     * @return InternalIncident
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin = null)
    {
        $this->network_admin = $networkAdmin;

        return $this;
    }

    public function isInternal()
    {
        return true;
    }

    public function isExternal()
    {
        return false;
    }

}
