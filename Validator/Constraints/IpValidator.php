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

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\IpValidator as IpValidatorConstraint;

class IpValidator extends IpValidatorConstraint
{

    public function validate($value, Constraint $constraint)
    {
        $ipes = explode(',', $value);
        foreach ($ipes as $ip) {
            parent::validate($ip, $constraint);
        }
    }

}
