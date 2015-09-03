<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use CertUnlp\NgenBundle\Services\NetworkHandler;

class ValidNetworkValidator extends ConstraintValidator {

    public function __construct(ObjectManager $om, NetworkHandler $networkHandler) {
        $this->om = $om;
        $this->network_handler = $networkHandler;
    }

    public function validate($value, Constraint $constraint) {
        $hostAddresses = explode(',', $value);
        foreach ($hostAddresses as $hostAddress) {
            if (!$this->network_handler->getByHostAddress($hostAddress)) {
                $this->context->addViolation(
                        $constraint->message, array('%string%' => $hostAddress)
                );
            }
        }
    }

}
