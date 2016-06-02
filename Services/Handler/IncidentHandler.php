<?php

/*
 * This file is part of the Ngen - CSIRT InternalIncident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use \CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Services\Handler\Handler;
use CertUnlp\NgenBundle\Services\Handler\UserHandler;

abstract class IncidentHandler extends Handler {

    private $user_handler;
    private $context;

    public function __construct(ObjectManager $om, $entityClass, $entityType, FormFactoryInterface $formFactory, SecurityContext $context, UserHandler $user_handler) {
        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->user_handler = $user_handler;
        $this->context = $context;
    }

    public function getUser() {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

    protected function prepareToDeletion($incident, array $parameters) {
        $incident->close();
    }

    /**
     * Delete a InternalIncident.
     *
     * @param IncidentInterface $incident
     * @param array $parameters
     *
     * @return IncidentInterface
     */
    public function changeState($incident, $state) {

        $incident->setState($state);
        return $this->patch($incident, $parameters);
    }

    /**
     * Processes the form.
     *
     * @param IncidentInterface $incident
     * @param array         $parameters
     * @param String        $method
     *
     * @return IncidentInterface
     *
     * @throws \CertUnlp\NgenBundle\Exception\InvalidFormException
     */
    protected function processForm($incident, $parameters, $method = "PUT", $csrf_protection = true) {
        if (!isset($parameters['reporter']) || !$parameters['reporter']) {
            $parameters['reporter'] = $this->getReporter();
        }
        return parent::processForm($incident, $parameters, $method, $csrf_protection);
    }

    protected function getReporter() {
        if ($this->getUser() != 'anon.') {
            return strval($this->getUser()->getId());
        } else {
            return $this->user_handler->findOneRandom()->getId();
        }
    }

    public function closeOldIncidents($days = 10) {
        $incidents = $this->all(['isClosed' => false]);
        $state = $this->om->getRepository('CertUnlp\NgenBundle\Entity\IncidentState')->findOneBySlug('closed_by_inactivity');
        $closedIncidents = [];
        foreach ($incidents as $incident) {
            if ($incident->getOpenDays(true) >= $days) {
                $incident->setState($state);
                $this->om->persist($incident);
                $closedIncidents[$incident->getId()] = ['hostAddress' => $incident->getHostAddress(),
                    'type' => $incident->getType(),
                    'date' => getDate(),
                    'lastTimeDetected' => $incident->getLastTimeDetected(),
                    'openDays' => $incident->getOpenDays(true)];
            }
            $this->om->flush($incident);
        }
        return $closedIncidents;
    }

    public function renotificateIncidents() {
        return $this->repository->findRenotificables();
    }

}
