<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Services\NetworkHandler;

/**
 * Description of IncidentFactory
 *
 * @author dam
 */
class IncidentFactory {

    private $network_handler;
    private $external_incident_class;
    private $internal_incident_class;

    public function __construct(NetworkHandler $network_handler, $external_incident_class, $internal_incident_class) {

        $this->network_handler = $network_handler;
        $this->external_incident_class = $external_incident_class;
        $this->internal_incident_class = $internal_incident_class;
    }

    public function getIncident($host_address) {
        if ($this->network_handler->getByHostAddress($host_address)) {
            $class = $this->internal_incident_class;
        } else {
            $class = $this->external_incident_class;
        }

        $incident = new $class();

        return $incident;
    }

}
