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
use Symfony\Component\Validator\ConstraintValidator;

class EntityNotActiveValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if ($value && !empty($constraint->message) && !$value->isActive() && $value->getSlug() !== 'undefined') {
            $name = explode('\\', get_class($value));
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->setParameter('{{ entity }}', end($name))
                ->addViolation();
        }
    }

}
