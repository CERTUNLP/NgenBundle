<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Delegator;

use CertUnlp\NgenBundle\Services\Delegator\DelegatorChain;

/**
 * Description of IncidentDelegatorChain
 *
 * @author demyen
 */
class InternalIncidentDelegatorChain extends DelegatorChain {

    public function doDelegation($function, $arguments) {
        parent::doDelegation($function, $arguments[0]);
    }

}
