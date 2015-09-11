<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use \CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;

class IncidentHandler {

    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory, SecurityContext $context, $reporter_class) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->reporter_class = $reporter_class;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
        $this->context = $context;
    }

    public function getUser() {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

    /**
     * Get a Incident.
     *
     * @param mixed $id
     *
     * @return IncidentInterface
     */
    public function get($id) {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Incidents.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($params = array(),$order = array(), $limit = null, $offset = null) {
        return $this->repository->findBy($params, $order, $limit, $offset);
    }

    /**
     * Create a new Incident.
     *
     * @param array $parameters
     *
     * @return IncidentInterface
     */
    public function post($parameters, $csrf_protection = false) {
        $incident = $this->createIncident();

        return $this->processForm($incident, $parameters, 'POST', $csrf_protection);
    }

    /**
     * Edit a Incident.
     *
     * @param IncidentInterface $incident
     * @param array         $parameters
     *
     * @return IncidentInterface
     */
    public function put($incident, array $parameters) {
        return $this->processForm($incident, $parameters, 'PUT');
    }

    /**
     * Partially update a Incident.
     *
     * @param IncidentInterface $incident
     * @param array         $parameters
     *
     * @return IncidentInterface
     */
    public function patch($incident, array $parameters) {
        return $this->processForm($incident, $parameters, 'PATCH', false);
    }

    /**
     * Delete a Incident.
     *
     * @param IncidentInterface $incident
     * @param array $parameters
     *
     * @return IncidentInterface
     */
    public function delete($incident, array $parameters) {
        $incident->close();
        $this->om->flush($incident);
        return $incident;
    }

    /**
     * Delete a Incident.
     *
     * @param IncidentInterface $incident
     * @param array $parameters
     *
     * @return IncidentInterface
     */
    public function changeState($incident, $state) {

        $incident->setState($state);
        return $this->processForm($incident, [], 'PATCH', false);
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
    private function processForm($incident, $parameters, $method = "PUT", $csrf_protection = true) {
        if (!isset($parameters['reporter']) || !$parameters['reporter']) {
            $parameters['reporter'] = $this->getReporter();
        }
        $form = $this->formFactory->create(new \CertUnlp\NgenBundle\Form\IncidentType(), $incident, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $incident = $form->getData();

            $incident = $this->checkIfIncidentExists($incident, $method);
            $this->om->persist($incident);
            $this->om->flush($incident);

            return $incident;
        }
        throw new InvalidFormException
        ('Invalid submitted data', $form);
    }

    private function checkIfIncidentExists($incident, $method) {
        $incidentDB = $this->repository->findOneBy(['isClosed' => false, 'hostAddress' => $incident->getHostAddress(), 'type' => $incident->getType()]);
        if ($incidentDB && $method == 'POST') {

            if ($incidentDB->getFeed()->getSlug() == "shadowserver") {
                $incidentDB->setSendReport(false);
            } else {
                $incidentDB->setSendReport($incident->getSendReport());
            }
            $incident = $incidentDB;
            $incident->setLastTimeDetected(new \DateTime('now'));
        }
        return $incident;
    }

    private function createIncident() {

        return new $this->entityClass();
    }

    private function getReporter() {
        if ($this->getUser() != 'anon.') {
            return strval($this->getUser()->getId());
        } else {
            $reporter_repository = $this->om->getRepository($this->reporter_class);
            return $reporter_repository->
                            findOneRandom()->getId();
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
