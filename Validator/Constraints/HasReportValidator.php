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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HasReportValidator extends ConstraintValidator
{
    private string $ngen_lang;

    public function __construct(string $ngen_lang)
    {
        $this->ngen_lang = $ngen_lang;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value && !empty($constraint->message) && $value->isNeedToCommunicate() && !$value->getType()->getReport($this->getNgenLang())) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ type }}', $value->getType()->getSlug())
                ->setParameter('{{ lang }}', $this->getNgenLang())
                ->atPath('type')
                ->addViolation();
        }
    }

    /**
     * @return string
     */
    public function getNgenLang(): string
    {
        return $this->ngen_lang;
    }

}
