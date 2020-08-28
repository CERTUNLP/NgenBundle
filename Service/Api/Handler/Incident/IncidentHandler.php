<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler\Incident;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Form\Incident\IncidentType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\Incident\IncidentRepository;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\HostHandler;
use CertUnlp\NgenBundle\Service\Api\Handler\Handler;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\State\IncidentStateHandler;
use CertUnlp\NgenBundle\Service\Api\Handler\User\UserHandler;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class IncidentHandler extends Handler
{

    /**
     * @var HostHandler
     */
    private $host_handler;

    /**
     * @var IncidentDecisionHandler
     */
    private $decision_handler;
    /**
     * @var IncidentStateHandler
     */
    private $incident_state_handler;
    /**
     * @var TokenStorageInterface
     */
    private $token_storage;
    /**
     * @var IncidentPriorityHandler
     */
    private $incident_priority_handler;

    public function __construct(EntityManagerInterface $entity_manager, IncidentRepository $repository, IncidentType $entity_type, FormFactoryInterface $form_factory, TokenStorageInterface $token_storage, UserHandler $user_handler, HostHandler $host_handler, IncidentDecisionHandler $decision_handler, IncidentStateHandler $incident_state_handler, IncidentPriorityHandler $incident_priority_handler)
    {
        parent::__construct($entity_manager, $repository, $entity_type, $form_factory);
        $this->host_handler = $host_handler;
        $this->decision_handler = $decision_handler;
        $this->incident_state_handler = $incident_state_handler;
        $this->token_storage = $token_storage;
        $this->incident_priority_handler = $incident_priority_handler;
    }


    /**
     * @param Incident|EntityApiInterface $incident
     * @param IncidentState $state
     * @return EntityApiInterface|Incident
     */
    public function changeState(Incident $incident, IncidentState $state): EntityApiInterface
    {
        $incident->setState($state);
        return $this->patch($incident, []);
    }


    /**
     * {@inheritDoc}
     */
    public function patch(EntityApiInterface $entity, array $parameters = []): EntityApiInterface
    {
        $entity->setResponsable($this->getUser());
        return parent::patch($entity, $parameters);
    }

    /**
     * @return User|object|string
     */
    public function getUser(): ?User
    {
        return $this->getTokenStorage()->getToken() ? $this->getTokenStorage()->getToken()->getUser() : null;
    }

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->token_storage;
    }

    /**
     * @return array|Incident[]
     */
    public function getToNotificateIncidents(): array
    {
        return $this->getRepository()->findNotificables();
    }

    /**
     * @return array|array[]
     */
    public function closeUnsolvedIncidents(): array
    {
        $incidents = $this->findAllUnsolved();
        $closedIncidents = [];
        $unClosedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->setState($incident->getUnsolvedState())) {
                //$this->entity_manager->persist($incident);
                $closedIncidents[$incident->getId()] = [
                    'id' => $incident->getSlug(),
                    'type' => $incident->getType()->getSlug(),
                    'date' => $incident->getDate()->format('Y-m-d H:i:s'),
                    'updated' => $incident->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'newState' => $incident->getState()->getSlug()
                ];
            } else {
                $unClosedIncidents[$incident->getId()] = [
                    'id' => $incident->getSlug(),
                    'type' => $incident->getType()->getSlug(),
                    'date' => $incident->getDate()->format('Y-m-d H:i:s'),
                    'updated' => $incident->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'actualState' => $incident->getState()->getSlug(),
                    'requiredState' => $incident->getUnsolvedState()->getSlug()
                ];
            }
        }
        $this->getEntityManager()->flush();
        return array($closedIncidents, $unClosedIncidents);
    }

    /**
     * @return array| Incident[]
     */
    public function findAllUnsolved(): array
    {
        return $this->getRepository()->findAllUnsolved();
    }

    /**
     * @return array|array[]
     */
    public function closeUnattendedIncidents(): array
    {
        $incidents = $this->findAllUnattended();
        $closedIncidents = [];
        $unClosedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->setState($incident->getUnattendedState())) {
                //$this->entity_manager->persist($incident);
                $closedIncidents[$incident->getId()] = ['id' => $incident->getSlug(),
                    'type' => $incident->getType()->getSlug(),
                    'date' => $incident->getDate()->format('Y-m-d H:i:s'),
                    'updated' => $incident->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'newState' => $incident->getState()->getSlug()];
            } else {
                $unClosedIncidents[$incident->getId()] = [
                    'id' => $incident->getSlug(),
                    'type' => $incident->getType()->getSlug(),
                    'date' => $incident->getDate()->format('Y-m-d H:i:s'),
                    'updated' => $incident->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'actualState' => $incident->getState()->getSlug(),
                    'requiredState' => $incident->getUnattendedState()
                ];
            }

        }
        $this->getEntityManager()->flush();
        return array($closedIncidents, $unClosedIncidents);
    }

    /**
     * @return array| Incident[]
     */
    public function findAllUnattended(): array
    {
        return $this->getRepository()->findAllUnattended();
    }

    /**
     * @param EntityApiInterface|Incident $entity_api
     * @param string|null $method
     * @return EntityApiInterface|Incident
     * @throws Exception
     */
    public function postValidationForm(EntityApiInterface $entity_api, string $method = null): EntityApiInterface
    {
        $this->updateIncidentData($entity_api);
        if ($method === Request::METHOD_POST) {
            $entity_db = $this->getByDataIdentification($entity_api);
            if ($entity_db) {
                $entity_db->updateFromDetection($entity_api);
                $entity_db->addIncidentDetected($entity_api);
                return $entity_db;
            }
        }
        return $entity_api;
    }

    /**
     * @param Incident $incident
     * @throws Exception
     */
    public function updateIncidentData(Incident $incident): void
    {
        $this->hostUpdate($incident);
        $this->networkUpdate($incident);
        $this->decisionUpdate($incident);
        $this->timestampsUpdate($incident);
        $this->slugUpdate($incident);
        $this->priorityUpdate($incident);
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function hostUpdate(Incident $incident): Incident
    {
        if ($incident->getAddress()) {
            $host = $incident->getOrigin();
            $host_new = $this->getHostHandler()->getRepository()->findOneByAddress($incident->getAddress()) ?: $this->getHostHandler()->post(['address' => $incident->getAddress()]);
            if ($host_new) {
                if ($host) {
                    if (!$host->equals($host_new) && $incident->isLive()) {
                        $incident->setOrigin($host_new);
                    }
                } else {
                    $incident->setOrigin($host_new);
                }
            }
        }
        return $incident;
    }

    /**
     * @return HostHandler
     */
    public function getHostHandler(): HostHandler
    {
        return $this->host_handler;
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function networkUpdate(Incident $incident): Incident
    {
        if ($incident->getAddress()) {
            $network = $incident->getNetwork();
            $network_new = $incident->getOrigin()->getNetwork();
            if ($network_new) {
                if ($network) {
                    if (!$network->equals($network_new) && $incident->isLive()) {
                        $incident->setNetwork($network_new);
                    }
                } else {
                    $incident->setNetwork($network_new);
                }
            }
        }
        return $incident;
    }

    /**
     * @param Incident $incident
     * @return Incident|null
     * @throws Exception
     */
    public function decisionUpdate(Incident $incident): ?Incident
    {
        return $this->getDecisionHandler()->getByIncident($incident)->doDecision($incident);
    }

    /**
     * @return IncidentDecisionHandler
     */
    public function getDecisionHandler(): IncidentDecisionHandler
    {
        return $this->decision_handler;
    }

    /**
     * @param Incident $incident
     */
    public function timestampsUpdate(Incident $incident): void
    {
        if ($incident->getDate() == null) {
            $incident->setDate(new DateTime('now'));
        }
    }

    /**
     * @param Incident $incident
     */
    public function slugUpdate(Incident $incident): void
    {
        $firstPart = $incident->getOrigin() ? $incident->getOrigin()->getAddress() : sha1(uniqid(mt_rand(), true));
        $secondPart = $incident->getState() ?: sha1(uniqid(mt_rand(), true));
        $incident->setSlug(Sluggable\Urlizer::urlize($firstPart . ' ' . $secondPart . ' ' . $incident->getDate()->format('Y-m-d-H-i'), '_'));
    }

    /**
     * @param Incident $incident
     */
    public function priorityUpdate(Incident $incident): void
    {
        $impact = $incident->getImpact() ? $incident->getImpact()->getSlug() : null;
        $urgency = $incident->getUrgency() ? $incident->getUrgency()->getSlug() : null;
        if ($impact && $urgency) {
            $priority = $this->getIncidentPriorityHandler()->get(['impact' => $incident->getImpact()->getSlug(), 'urgency' => $incident->getUrgency()->getSlug()]);
            $incident->setPriority($priority);
        }
    }

    /**
     * @return IncidentPriorityHandler
     */
    public function getIncidentPriorityHandler(): IncidentPriorityHandler
    {
        return $this->incident_priority_handler;
    }

    /**
     * @param EntityApiInterface|Incident $entity
     * @return EntityApiInterface|Incident
     */
    public function getDataByIdentification(EntityApiInterface $entity): ?EntityApiInterface
    {
        if ($entity->isDefined()) {
            return $this->getRepository()->findOneLiveBy($entity->getDataIdentificationArray());
        }
        return null;

    }

    /**
     * {@inheritDoc}
     */
    public function getByParamIdentification(array $parameters): ?EntityApiInterface
    {
        $parameters = $this->getParamIdentificationArray($parameters);
        return $this->findOneByTypeAndAddress($parameters['type'], $parameters['address']);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['type' => $parameters['type'], 'address' => $parameters['address']];
    }

    /**
     * @param string $type
     * @param string|null $address
     * @return mixed
     */
    public function findOneByTypeAndAddress(string $type, string $address = null): ?EntityApiInterface
    {
        return $this->getRepository()->findOneByTypeAndAddress($type, $address);

    }

    /**
     * @param array $parameters
     * @return array
     */
    public function cleanParameters(array $parameters): array
    {
        $parameters = parent::cleanParameters($parameters);
        if (!isset($parameters['reporter']) || !$parameters['reporter']) {
            if ($this->getUser()) {
                $parameters['reporter'] = $this->getUser()->getId();
            }
        }
        return $parameters;
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|Incident
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
    {
        $class_name = $this->getRepository()->getClassName();
        $incident = new $class_name($params['address'] ?? null);
        $incident->setState($this->getInitialState());
        return $incident;
    }

    /**
     * @return IncidentState
     */
    public function getInitialState(): IncidentState
    {
        return $this->getIncidentStateHandler()->getInitialState();
    }

    /**
     * @return IncidentStateHandler
     */
    public function getIncidentStateHandler(): IncidentStateHandler
    {
        return $this->incident_state_handler;
    }
}
