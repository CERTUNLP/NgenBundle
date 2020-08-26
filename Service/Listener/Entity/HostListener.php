<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\Network\NetworkHandler;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Sluggable\Util as Sluggable;


class HostListener
{
    /**
     * @var NetworkHandler
     */
    private $network_handler;

    public function __construct(NetworkHandler $network_handler)
    {
        $this->network_handler = $network_handler;
    }

    /** @ORM\PostLoad()
     * @param Host $host
     */
    public function postLoadHandler(Host $host): void
    {
        $host->guessAddress($host->getIp() ?? $host->getDomain());
//        $this->networkUpdate($host);
    }

    /**
     * @ORM\PrePersist
     * @param Host $host
     */
    public function prePersistHandler(Host $host): void
    {
        $host->guessAddress($host->getIp() ?? $host->getDomain());
        $this->prePersistUpdate($host);
    }

    /**
     * @param Host $host
     */
    public function prePersistUpdate(Host $host): void
    {
        $this->slugUpdate($host);
        $this->networkUpdate($host);
    }

    /**
     * @param Host $host
     */
    public function slugUpdate(Host $host): void
    {
        $host->setSlug(Sluggable\Urlizer::urlize($host->getAddress()));
    }

    /**
     * @param Host $host
     */
    public function networkUpdate(Host $host): void
    {
        $network = $this->getNetworkHandler()->findOneInRange($host->getAddress());
        $host->setNetwork($network);
    }

    /**
     * @return NetworkHandler
     */
    public function getNetworkHandler(): NetworkHandler
    {
        return $this->network_handler;
    }




}
