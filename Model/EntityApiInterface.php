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


interface  EntityApiInterface extends EntityInterface
{
    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @return EntityApiInterface
     */
    public function activate(): EntityApiInterface;

    /**
     * @return EntityApiInterface
     */
    public function desactivate(): EntityApiInterface;

    /**
     * @return string
     */
    public function getIdentificationString(): string;

    /**
     * @return array
     */
    public function getIdentificationArray(): array;
}

