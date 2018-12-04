<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Converter;

/**
 * Description of IncidentConvertible
 *
 * @author demyen
 */
interface IncidentConvertible extends Convertible
{

    public function getIp();

    public function getType();

    public function getFeed();

    public function getReporter();

    public function getEvidenceFile();
}
