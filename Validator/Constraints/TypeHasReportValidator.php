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

use CertUnlp\NgenBundle\Services\Api\Handler\IncidentTypeHandler;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TypeHasReportValidator extends ConstraintValidator
{

    private $type_handler;
    private $lang;

    public function __construct(IncidentTypeHandler $networkHandler, $lang)
    {
        $this->type_handler = $networkHandler;
        $this->lang = $lang;
    }

    public function validate($value, Constraint $constraint)
    {
        $type = $this->type_handler->get(['slug' => $value]);
        if ($type && !$type->getReport($this->lang)) {
            if (!empty($constraint->message)) {
                $this->context->addViolation(
                    $constraint->message, array('%string%' => $this->lang)
                );
            }
        }
    }

}
