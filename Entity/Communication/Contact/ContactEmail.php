<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication\Contact;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @author einar
 * @ORM\Entity()
 */
class ContactEmail extends Contact
{

    public function getEmail(): string
    {
        return $this->getUsername();
    }

    /**
     * @return string
     */
    public function getTelegram(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getTreema(): string
    {
        return '';
    }
}
