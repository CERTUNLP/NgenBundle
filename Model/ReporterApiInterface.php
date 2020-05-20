<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Model;

interface ReporterInterface
{
    /**
     * @return string
     */
    public function getFirstname(): string;

    /**
     * @return string
     */
    public function getLastname(): string;

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getEmail();
}
