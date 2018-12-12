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
    private $external_lang;
    private $internal_lang;

    public function __construct(IncidentTypeHandler $networkHandler, $internal_lang, $external_lang)
    {
        $this->type_handler = $networkHandler;
        $this->internal_lang = $internal_lang;
        $this->external_lang = $external_lang;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value->isInternal()) {
            $lang = $this->internal_lang;
        } else {
            $lang = $this->external_lang;
        }
        $type = $value->getType();

        if ($type && !$type->getReport($lang) && $value->getType()->getSlug() !== 'undefined') {
            if (!empty($constraint->message)) {
                $this->context->addViolation(
                    $constraint->message, array('%string%' => $lang)
                );
            }
        }
    }

}
