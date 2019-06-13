<?php

namespace CertUnlp\NgenBundle\Services\StateMachine;

use CertUnlp\NgenBundle\Services\Api\Handler\IncidentStateEdgeHandler;

class StateMachine
{


    private $incident_state_edge_handler;

    public function __construct($incident_state_edge_handler)
    {
        $this->incident_state_edge_handler = $incident_state_edge_handler;
    }

    /**
     * @return mixed
     */
    public function getIncidentStateEdgeHandler(): IncidentStateEdgeHandler
    {
        return $this->incident_state_edge_handler;
    }

    /**
     * @param mixed $incident_state_edge
     * @return StateMachine
     */
    public function setIncidentStateEdgeHandler(IncidentStateEdgeHandler $incident_state_edge)
    {
        $this->incident_state_edge_handler = $incident_state_edge;
        return $this;
    }

}