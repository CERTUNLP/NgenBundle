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

use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidAddressValidator extends ConstraintValidator
{


    public function validate($value, Constraint $constraint)
    {
        if ($value && !empty($constraint->message) && !NetworkElement::guessType($value)) {
            $this->context->addViolation(
                $constraint->message, array('%string%' => $value)
            );
        }
    }

}
