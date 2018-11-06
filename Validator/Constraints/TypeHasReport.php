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

/**
 * @Annotation
 */
class TypeHasReport extends Constraint
{

    public $message = 'This type does\'n have a report for this language ("%string%")';

    public function validatedBy()
    {
        return 'type.has.report.validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
