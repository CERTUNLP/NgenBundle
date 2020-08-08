<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use Doctrine\ORM\Mapping as ORM;


class IncidentPriorityListener
{

    /** @ORM\PrePersist
     * @param IncidentPriority $priority
     */
    public function prePersistHandler(IncidentPriority $priority): void
    {
        $this->prePersistUpdate($priority);
    }

    public function prePersistUpdate(IncidentPriority $priority): void
    {
        $this->slugUpdate($priority);
    }

    public function slugUpdate(IncidentPriority $priority): void
    {
        $priority->setSlug($priority->getImpact()->getSlug() . '_' . $priority->getUrgency()->getSlug());
    }

    /** @ORM\PreUpdate
     * @param IncidentPriority $priority
     */
    public function preUpdateHandler(IncidentPriority $priority): void
    {
        $this->prePersistUpdate($priority);
    }


}
