<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;


class NetworkListener
{
    /** @ORM\PostLoad()
     * @param Network $network
     */
    public function prePersistHandler(Network $network): void
    {
        if ($network->getIp()) {
            $network->guessAddress($network->getIp() . '/' . $network->getIpMask());
        } else {
            $network->guessAddress($network->getIp() ?? $network->getDomain());
        }
    }


}
