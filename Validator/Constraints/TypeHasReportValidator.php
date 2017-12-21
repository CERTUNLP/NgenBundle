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
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentTypeHandler;

class TypeHasReportValidator extends ConstraintValidator {

    public function __construct(IncidentTypeHandler $networkHandler, $lang) {
        $this->type_handler = $networkHandler;
        $this->lang = $lang;
    }

    public function validate($value, Constraint $constraint) {
        $type = $this->type_handler->get(['slug' => $value]);
        if ($type && !$type->getReport($this->lang)) {
            $this->context->addViolation(
                    $constraint->message, array('%string%' => $this->lang)
            );
        }
    }

}
