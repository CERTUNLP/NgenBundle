<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Contact;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @author einar
 * @ORM\Entity()
 */
class ContactTelegram extends Contact
{

    public function getType(): string
    {
        return 'telegram';
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getTelegram(): string
    {
        return $this->getUsername();
    }
}
