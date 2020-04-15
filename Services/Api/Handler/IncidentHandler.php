<?php

/*
 * This file is part of the Ngen - CSIRT InternalIncident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class IncidentHandler extends Handler
{
    private $user_handler;
    private $context;
    private $host_handler;
    private $decision_handler;
    private $incidentStateHandler;

    public function __construct(ObjectManager $om, string $entityClass, string $entityType, FormFactoryInterface $formFactory, TokenStorageInterface $context, UserHandler $user_handler, HostHandler $host_handler, IncidentDecisionHandler $decision_handler, IncidentStateHandler $incidentStateHandler)
    {

        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->host_handler = $host_handler;
        $this->user_handler = $user_handler;
        $this->decision_handler = $decision_handler;
        $this->incidentStateHandler = $incidentStateHandler;
        $this->context = $context;
    }

    /**
     * @return UserHandler
     */
    public function getUserHandler(): UserHandler
    {
        return $this->user_handler;
    }

    /**
     * @param UserHandler $user_handler
     * @return IncidentHandler
     */
    public function setUserHandler(UserHandler $user_handler): IncidentHandler
    {
        $this->user_handler = $user_handler;
        return $this;
    }

    /**
     * @return TokenStorageInterface
     */
    public function getContext(): TokenStorageInterface
    {
        return $this->context;
    }

    /**
     * @param TokenStorageInterface $context
     * @return IncidentHandler
     */
    public function setContext(TokenStorageInterface $context): IncidentHandler
    {
        $this->context = $context;
        return $this;
    }

    /**
     * Delete a InternalIncident.
     *
     * @param Incident $incident
     * @param $state
     * @return Incident|object
     * @throws Exception
     */
    public function changeState(Incident $incident, $state)
    {
        $incident->setStateAndReporter($state, $this->getReporter());
        return $this->patch($incident, []);
    }

    /**
     * @return User|object|string
     */
    public function getReporter()
    {
        return $this->getUser();
    }

    /**
     * @return User|object|string
     */
    public function getUser()
    {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

    /**
     * @return array
     */
    public function getToNotificateIncidents(): array
    {
        return $this->getRepository()->findNotificables();
    }


    /**
     * @return array
     */
    public function closeUnsolvedIncidents(): array
    {
        $incidents = $this->findAllUnsolved();
        $closedIncidents = [];
        $unClosedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->setState($incident->getUnsolvedState())) {
                //$this->om->persist($incident);
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
        $this->om->flush();
        return array($closedIncidents, $unClosedIncidents);
    }

    /**
     * @return array| Incident[]
     */
    public function findAllUnsolved(): array
    {
        return $this->getRepository()->findAllUnsolved();
    }

    public function closeUnattendedIncidents(): array
    {
        $incidents = $this->findAllUnattended();
        $closedIncidents = [];
        $unClosedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->setState($incident->getUnattendedState())) {
                //$this->om->persist($incident);
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
        $this->om->flush();
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
     * @param $incident Incident
     * @param string $method
     * @return object|null
     * @throws Exception
     */
    public function checkIfExists($incident, $method)
    {
        $this->updateIncidentData($incident);
        if ($method === 'POST') {
            $incident = $this->addIncidentDetected($incident);
        }
        return $incident;
    }

    /**
     * @param Incident $incident
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
     * @param HostHandler $host_handler
     * @return IncidentHandler
     */
    public function setHostHandler(HostHandler $host_handler): IncidentHandler
    {
        $this->host_handler = $host_handler;
        return $this;
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
     * @param IncidentDecisionHandler $decision_handler
     * @return IncidentHandler
     */
    public function setDecisionHandler(IncidentDecisionHandler $decision_handler): IncidentHandler
    {
        $this->decision_handler = $decision_handler;
        return $this;
    }

    public function timestampsUpdate(Incident $incident): void
    {
        //FIX comprobar que actualice el updated
        if ($incident->getDate() == null) {
            try {
                $incident->setDate(new DateTime('now'));
            } catch (Exception $e) {
            }
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

    public function priorityUpdate(Incident $incident): void
    {
        $repository = $this->om->getRepository(IncidentPriority::class);
        $priority = $repository->findOneBy(array('impact' => $incident->getImpact()->getSlug(), 'urgency' => $incident->getUrgency()->getSlug()));
        $incident->setPriority($priority);
    }

    /**
     * @param Incident $incident
     * @return Incident
     * @throws NonUniqueResultException
     */
    public function addIncidentDetected(Incident $incident): Incident
    {
        $incidentDB = null;
        if ($incident->isDefined()) {
            $incidentDB = $this->getRepository()->findOneLiveBy(['origin' => $incident->getOrigin()->getId(), 'type' => $incident->getType()->getSlug()]);
        }

        if ($incidentDB) {
            $incidentDB->updateVariables($incident);
            $incidentDB->addIncidentDetected($incident);
            return $incidentDB;
        }
        $incident->addIncidentDetected($incident);
        return $incident;
    }

    /**
     * @param Incident $incident
     * @param array $parameters
     * @return object|void
     */
    protected function prepareToDeletion($incident, array $parameters)
    {
        $incident->close();
    }

    /**
     * Processes the form.
     *
     * @param Incident $incident
     * @param array $parameters
     * @param String $method
     *
     * @param bool $csrf_protection
     * @return Incident|object
     *
     */
    protected function processForm($incident, $parameters, $method = "PUT", $csrf_protection = true)
    {
        if (!isset($parameters['reporter']) || !$parameters['reporter']) {
            $parameters['reporter'] = $this->getReporter()->getId();
        }

        return parent::processForm($incident, $parameters, $method, $csrf_protection);
    }

    protected function createEntityInstance(array $params)
    {
        $incident = new $this->entityClass($params['address'] ?? null);
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
        return $this->incidentStateHandler;
    }

    /**
     * @param IncidentStateHandler $incidentStateHandler
     * @return IncidentHandler
     */
    public function setIncidentStateHandler(IncidentStateHandler $incidentStateHandler): IncidentHandler
    {
        $this->incidentStateHandler = $incidentStateHandler;
        return $this;
    }


}
