<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\IncidentPriorityHandler;
use Doctrine\ORM\Mapping as ORM;


class IncidentDecisionListener
{
    /**
     * @var IncidentPriorityHandler
     */
    private $priority_handler;

    public function __construct(IncidentPriorityHandler $priority_handler)
    {
        $this->priority_handler = $priority_handler;
    }


    /**
     * @param IncidentDecision $decision
     */
    public function priorityUpdate(IncidentDecision $decision): void
    {
        if ($decision->getImpact() && $decision->getUrgency()) {
            if ($decision->getImpact()->isUndefined() || $decision->getUrgency()->isUndefined()) {
                $priority = $this->getPriorityHandler()->get(['impact' => 'undefined', 'urgency' => 'undefined']);
            } else {
                $priority = $this->getPriorityHandler()->get(['impact' => $decision->getImpact()->getSlug(), 'urgency' => $decision->getUrgency()->getSlug()]);
            }
            $decision->setPriority($priority);
        }
    }

    /**
     * @return IncidentPriorityHandler
     */
    public function getPriorityHandler(): IncidentPriorityHandler
    {
        return $this->priority_handler;
    }

    /** @ORM\PreFlush
     * @param IncidentDecision $decision
     */
    public function preUpdateHandler(IncidentDecision $decision): void
    {
        $this->priorityUpdate($decision);
    }


}
