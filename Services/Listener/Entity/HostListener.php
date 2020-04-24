<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkHandler;
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

    /** @ORM\PrePersist
     * @param Host $host
     */
    public function prePersistHandler(Host $host): void
    {
        $host->guessAddress($host->getIp() ?? $host->getDomain());

        $this->incidentPrePersistUpdate($host);
    }

    public function incidentPrePersistUpdate(Host $host): void
    {
        $this->slugUpdate($host);
        $this->networkUpdate($host);
    }

    public function slugUpdate(Host $incident): void
    {
        $incident->setSlug(Sluggable\Urlizer::urlize($incident->getAddress()));
    }

    /**
     * @param Host $host
     */
    public function networkUpdate(Host $host): void
    {
        $network = $host->getNetwork();
        $network_new = $this->getNetworkHandler()->getByHostAddress($host->getAddress());
        if ($network_new) {
            if ($network) {
                if (!$network->equals($network_new)) {
                    $host->setNetwork($network_new);
                }
            } else {
                $host->setNetwork($network_new);
            }
        }
    }

    /**
     * @return NetworkHandler
     */
    public function getNetworkHandler(): NetworkHandler
    {
        return $this->network_handler;
    }

    /** @ORM\PreUpdate
     * @param Host $host
     */
    public function preUpdateHandler(Host $host): void
    {
        $this->incidentPrePersistUpdate($host);
    }


}
