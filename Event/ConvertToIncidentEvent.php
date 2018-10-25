<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Event;

use CertUnlp\NgenBundle\Services\Converter\IncidentConvertible;
use Symfony\Component\EventDispatcher\Event;

class ConvertToIncidentEvent extends Event
{

    protected $convertible;

    public function __construct(IncidentConvertible $convertible)
    {
        $this->convertible = $convertible;
    }

    /**
     * @return IncidentConvertible
     */
    public function getConvertible()
    {
        return $this->convertible;
    }

}
