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
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContext;

class IncidentHandler extends Handler
{
    private $user_handler;
    private $context;
    private $host_handler;
    private $decision_handler;

    public function __construct(ObjectManager $om, string $entityClass, string $entityType, FormFactoryInterface $formFactory, SecurityContext $context, UserHandler $user_handler, HostHandler $host_handler, IncidentDecisionHandler $decision_handler)
    {

        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->host_handler = $host_handler;
        $this->user_handler = $user_handler;
        $this->decision_handler = $decision_handler;
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
     * @return SecurityContext
     */
    public function getContext(): SecurityContext
    {
        return $this->context;
    }

    /**
     * @param SecurityContext $context
     * @return IncidentHandler
     */
    public function setContext(SecurityContext $context): IncidentHandler
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
     */
    public function changeState(Incident $incident, $state)
    {
        $incident->setStateAndReporter($state, $this->getReporter());
        return $this->patch($incident, []);
    }

    public function getReporter()
    {
        return $this->getUser();
    }

    public function getUser()
    {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

    public function closeOldIncidents(int $days = 10): array
    {
        $incidents = $this->all(['isClosed' => false]);
        $state = $this->om->getRepository('CertUnlp\NgenBundle\Entity\Incident\IncidentState')->findOneBySlug('closed_by_inactivity');
        $closedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->getOpenDays(true) >= $days) {
                $incident->setState($state);
                $this->om->persist($incident, $this->getReporter());
                $closedIncidents[$incident->getId()] = ['ip' => $incident->getAddress(),
                    'type' => $incident->getType(),
                    'date' => $incident->getUpdatedAt(),
                    'lastTimeDetected' => $incident->getUpdatedAt(),
                    'openDays' => $incident->getOpenDays(true)];
            }
        }
        $this->om->flush();
        return $closedIncidents;
    }

    /**
     * @return mixed
     */
    public function renotificateIncidents()
    {
        return $this->repository->findRenotificables();
    }

    /**
     * @param $incident Incident
     * @param $method
     * @return object|null
     * @throws \Exception
     */
    public function checkIfExists($incident, $method)
    {
        $this->updateIncidentData($incident);
        $incidentDB = false;
        if ($incident->isDefined()) {
            $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'origin' => $incident->getOrigin()->getId(), 'type' => $incident->getType()->getSlug()]);
        }
        if ($incidentDB && $method === 'POST') {
//            if ($incident->getEvidenceFile()) {
//                $incidentDB->setEvidenceFile($incident->getEvidenceFile());
//            }
            $incidentDB->addIncidentDetected($incident);
            $incidentDB->updateVariables($incident);
            $incident = $incidentDB;
        } else {
            $incident->updateVariables($incident);
            $incident->addIncidentDetected($incident);

        }
        return $incident;
    }

    public function updateIncidentData(Incident $incident)
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
            $host_new = $this->getHostHandler()->findOneByAddress($incident->getAddress()) ?: $this->getHostHandler()->post(['address' => $incident->getAddress()]);
            if ($host) {

                if (!$host->equals($host_new) && !$incident->isClosed()) {
                    $incident->setOrigin($host_new);
                }
            } else {
                $incident->setOrigin($host_new);
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
     */
    public function networkUpdate(Incident $incident): void
    {
        if ($incident->getAddress()) {
            $network = $incident->getNetwork();
            $network_new = $incident->getOrigin()->getNetwork();
            if ($network) {
                if (!$network->equals($network_new) && !$incident->isClosed()) {
                    $incident->setNetwork($network_new);
                }
            } else {
                $incident->setNetwork($network_new);
            }
        }
    }

    public function decisionUpdate(Incident $incident): ?Incident
    {
        return $this->decision_handler->getByIncident($incident);
    }

    public function timestampsUpdate(Incident $incident): void
    {
        //FIX comprobar que actualice el updated
        if ($incident->getDate() == null) {
            try {
                $incident->setDate(new \DateTime('now'));
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param Incident $incident
     */
    public function slugUpdate(Incident $incident): void
    {
        $firstPart = $incident->getOrigin() ? $incident->getOrigin()->getAddress() : sha1(uniqid(mt_rand()));
        $secondPart = $incident->getState() ? $incident->getState() : sha1(uniqid(mt_rand()));
        $incident->setSlug(Sluggable\Urlizer::urlize($firstPart . ' ' . $secondPart . ' ' . $incident->getDate()->format('Y-m-d-H-i'), '_'));
    }

    public function priorityUpdate(Incident $incident): void
    {
        $repository = $this->om->getRepository(IncidentPriority::class);
        $priority = $repository->findOneBy(array('impact' => $incident->getImpact()->getSlug(), 'urgency' => $incident->getUrgency()->getSlug()));
        $incident->setPriority($priority);
    }

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
        return new $this->entityClass($params['address']);

    }

}
