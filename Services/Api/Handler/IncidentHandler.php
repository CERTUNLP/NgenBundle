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
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContext;

class IncidentHandler extends Handler
{

    private $user_handler;
    private $context;
    private $host_handler;

    public function __construct(ObjectManager $om, string $entityClass, string $entityType, FormFactoryInterface $formFactory, SecurityContext $context, UserHandler $user_handler, HostHandler $host_handler)
    {
        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->host_handler = $host_handler;
        $this->user_handler = $user_handler;
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
        $incident->setState($state);
        return $this->patch($incident, []);
    }

    public function closeOldIncidents(int $days = 10): array
    {
        $incidents = $this->all(['isClosed' => false]);
        $state = $this->om->getRepository('CertUnlp\NgenBundle\Entity\Incident\IncidentState')->findOneBySlug('closed_by_inactivity');
        $closedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->getOpenDays(true) >= $days) {
                $incident->setState($state);
                $this->om->persist($incident);
                $closedIncidents[$incident->getId()] = ['ip' => $incident->getIp(),
                    'type' => $incident->getType(),
                    'date' => getDate(),
                    'lastTimeDetected' => $incident->getLastTimeDetected(),
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
    protected function checkIfExists($incident, $method)
    {
        $this->hostUpdate($incident);
        $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'origin' => $incident->getOrigin()->getId(), 'type' => $incident->getType()]);
        if ($incidentDB && $method === 'POST') {
            if ($incident->getEvidenceFile()) {
                $incidentDB->setEvidenceFile($incident->getEvidenceFile());
            }
            $incident = $incidentDB;
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return $incident;
    }

    /**
     * @param Incident $incident
     */
    public function hostUpdate(Incident $incident): void
    {
        $host = $incident->getOrigin();
        $host_new = $this->getHostHandler()->findByIpV4($incident->getIp()) ?: $this->getHostHandler()->post(['ip_v4' => $incident->getIp()]);
        if ($host) {
            if (!$host->equals($host_new) && !$incident->isClosed()) {
                $incident->setOrigin($host_new);
            }
        } else {
            $incident->setOrigin($host_new);
        }
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
            $parameters['reporter'] = $this->getReporter();
        }


        return parent::processForm($incident, $parameters, $method, $csrf_protection);
    }

    protected function getReporter()
    {
        return (string)$this->getUser()->getId();
    }

    public function getUser()
    {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

}
