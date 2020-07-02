<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use ArrayIterator;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Form\IncidentDecisionType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\IncidentDecisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;

class IncidentDecisionHandler extends Handler
{
    /**
     * IncidentDecisionHandler constructor.
     * @param EntityManagerInterface $entity_manager
     * @param IncidentDecisionRepository $repository
     * @param IncidentDecisionType $entity_type
     * @param FormFactoryInterface $form_factory
     */
    public function __construct(EntityManagerInterface $entity_manager, IncidentDecisionRepository $repository, IncidentDecisionType $entity_type, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_type, $form_factory);
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface
     * @throws Exception
     */
    public function getByParamIdentification(array $parameters): ?EntityApiInterface
    {
        $parameters = $this->getParamIdentificationArray($parameters);
        return $this->getByNetwork($parameters['type'], $parameters['feed'], $parameters['network']);
    }

    /**
     * @inheritDoc
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['type' => $parameters['type'] ?? 'undefined', 'feed' => $parameters['feed'] ?? 'undefined', 'network' => $parameters['network'] ?? null];
    }

    /**
     * @param IncidentType|null $type
     * @param IncidentFeed|null $feed
     * @param Network|null $network
     * @return IncidentDecision|null
     * @throws Exception
     */
    public function getByNetwork(IncidentType $type = null, IncidentFeed $feed = null, Network $network = null): ?IncidentDecision
    {
        $decisions = new ArrayCollection($this->all(['type' => $type ? $type->getSlug() : 'undefined', 'feed' => $feed ? $feed->getSlug() : 'undefined', 'get_undefined' => true]));
        $ordered_decisions = $this->orderDecisionsByNetworkMask($decisions);

        foreach ($ordered_decisions as $decision) {
            if (($decision->getNetwork() === '') || ($network && $decision->getNetwork() && $network->inRange($decision->getNetwork()))) {
                return $decision;
            }
        }
        return $decisions->last() ?: null;
    }

    /**
     * @param ArrayCollection $decisions
     * @return ArrayIterator
     * @throws Exception
     */
    public function orderDecisionsByNetworkMask(ArrayCollection $decisions): ArrayIterator
    {
        $iterator = $decisions->getIterator();
        $iterator->uasort(static function (IncidentDecision $first, IncidentDecision $second) {
            return (int)($first->getNetwork() ? $first->getNetwork()->getAddressMask() : -1) <= (int)($second->getNetwork() ? $second->getNetwork()->getAddressMask() : -2);
        });
        return $iterator;
    }

    /**
     * @param Incident $incident
     * @return IncidentDecision
     * @throws Exception
     */
    public function getByIncident(Incident $incident): ?IncidentDecision
    {
        $decisions = new ArrayCollection($this->all(['type' => $incident->getType() ? $incident->getType()->getSlug() : 'undefined', 'feed' => $incident->getFeed() ? $incident->getFeed()->getSlug() : 'undefined', 'get_undefined' => true]));

        $ordered_decisions = $this->orderDecisionsByNetworkMask($decisions);

        foreach ($ordered_decisions as $decision) {
            if ($decision->getNetwork() === '' || ($incident->getNetwork() && $decision->getNetwork() && $incident->getNetwork()->inRange($decision->getNetwork()))) {
                return $decision;
            }
        }

        return $decisions->last() ?: null;
    }

}
