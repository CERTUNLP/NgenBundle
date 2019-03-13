<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

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

    public function getToken(): string
    {
        return $this->getData()['token'];
    }

    public function getChatID(): string
    {
        return $this->getData()['chatid'];
    }

    public function getMessage(): string
    {

        if ($this->getData()['priority'] === 'HIGH') {
            $state = "\u{274C}";
        } elseif ($this->getData()['priority'] === 'WARNING') {
            $state = "\u{1F4A5}";
        } elseif ($this->getData()['priority'] === 'CRITICAL') {
            $state = "\u{1F525}";
        } else {
            $state = "\u{2753}";
        }
        $formato = '%s Incidente en el host "*%s*" del tipo "*%s*" con un riesgo "*%s*"';
        if ($this->getData()['notes']) {
            $formato .= sprintf(PHP_EOL . PHP_EOL . '*Nota/Comentario:*  %s', $this->getData()['notes']);
        }
        return sprintf($formato, $state, $this->getData()['address'], $this->getData()['type'], $this->getData()['priority']);
    }

}