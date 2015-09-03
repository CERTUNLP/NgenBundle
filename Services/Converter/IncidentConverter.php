<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Converter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use CertUnlp\NgenBundle\Services\Converter\AbstractConverter;
use CertUnlp\NgenBundle\Services\Converter\Convertible;
use CertUnlp\NgenBundle\Event\ConvertToIncidentEvent;

/**
 * Description of IncidentConverter
 *
 * @author demyen
 */
class IncidentConverter extends AbstractConverter {

    public function __construct($event_dispatcher) {
        $this->event_dispatcher = $event_dispatcher;
    }

    public function convert(Convertible $convertible) {
        $this->event_dispatcher->dispatch('cert_unlp.incident.convert_to_incident.event', new ConvertToIncidentEvent($convertible));
    }

}
