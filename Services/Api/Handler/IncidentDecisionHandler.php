<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use ArrayIterator;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\Common\Collections\ArrayCollection;

class IncidentDecisionHandler extends Handler
{
    public function getByIncident(Incident $incident): ?Incident
    {
        $decisions = new ArrayCollection($this->all(['type' => $incident->getType() ? $incident->getType()->getSlug() : 'undefined', 'feed' => $incident->getFeed() ? $incident->getFeed()->getSlug() : 'undefined', 'get_undefined' => true]));

        $ordered_decisions = $this->orderDecisionsByNetworkMask($decisions);

        foreach ($ordered_decisions as $decision) {

            if ($incident->getNetwork() && $decision->getNetwork() && $incident->getNetwork()->inRange($decision->getNetwork())) {

                return $decision->doDecision($incident);
            }
        }

        return $decisions->last()->doDecision($incident);
    }

    public function orderDecisionsByNetworkMask(ArrayCollection $decisions): ArrayIterator
    {
        $iterator = $decisions->getIterator();
        $iterator->uasort(static function (IncidentDecision $first, IncidentDecision $second) {
            return (int)($first->getNetwork() ? $first->getNetwork()->getAddressMask() : -1) <= (int)($second->getNetwork() ? $second->getNetwork()->getAddressMask() : -2);
        });
        return $iterator;
    }

    public function getByNetwork(IncidentType $type = null, IncidentFeed $feed = null, Network $network = null): ?IncidentDecision
    {
        $decisions = new ArrayCollection($this->repository->findBy(['type' => $type ? $type->getSlug() : 'undefined', 'feed' => $feed ? $feed->getSlug() : 'undefined', 'get_undefined' => true]));
        $ordered_decisions = $this->orderDecisionsByNetworkMask($decisions);

        foreach ($ordered_decisions as $decision) {
            if ($network && $decision->getNetwork() && $network->inRange($decision->getNetwork())) {
                return $decision;
            }
        }
        return $decisions->last();
    }

    /**
     * Delete a Network.
     *
     * @param IncidentDecision $incident_decision
     * @param array $parameters
     *
     * @return void
     */
    public
    function prepareToDeletion($incident_decision, array $parameters = null)
    {
        $incident_decision->setIsActive(FALSE);
    }

    protected
    function checkIfExists($incidentDecision, $method)
    {
        $incidentDecisionDB = $this->repository->findOneBy(['type' => $incidentDecision->getType() ? $incidentDecision->getType()->getSlug() : 'undefined', 'feed' => $incidentDecision->getFeed() ? $incidentDecision->getFeed()->getSlug() : 'undefined', 'network' => $incidentDecision->getNetwork() ? $incidentDecision->getNetwork()->getId() : null]);

        if ($incidentDecisionDB && $method === 'POST') {
            $incidentDecision = $incidentDecisionDB;
        }
        return $incidentDecision;
    }

}