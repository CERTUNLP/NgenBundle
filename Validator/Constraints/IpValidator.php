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
use Symfony\Component\Validator\Constraints\IpValidator as IpValidatorConstraint;

class IpValidator extends IpValidatorConstraint {

    public function validate($value, Constraint $constraint) {
        $hostAddresses = explode(',', $value);
        foreach ($hostAddresses as $hostAddress) {
            parent::validate($hostAddress, $constraint);
        }
    }

}
