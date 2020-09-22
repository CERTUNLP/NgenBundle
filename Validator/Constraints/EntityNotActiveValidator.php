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
    public function validate($entity, Constraint $constraint)
    {

        if ($entity && !empty($constraint->message) && !$entity->isActive() && $entity->getSlug() !== 'undefined') {
            $name = explode('\\', get_class($entity));
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $entity)
                ->setParameter('{{ entity }}', end($name))
                ->addViolation();
        }
    }

}
