<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication;

use Doctrine\ORM\Mapping as ORM;

/**
 * TelegramMessage
 *
 * @author einar
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\TelegramMessageRepository")
 */
class TelegramMessage extends Message
{

    public function isTelegram(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->getData()['token'];
    }

    /**
     * @return string
     */
    public function getChatID(): string
    {
        return $this->getData()['chatid'];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData()['message'];
    }


}