<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication\Message;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * MessageTelegram
 * http://localhost:8000/app_dev.php/messages/2/pending*
 * @author einar
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Communication\Message\MessageTelegramRepository")
 */
class MessageTelegram extends Message
{
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
    public function getIcon(): string
    {
        return 'paper-plane';
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData()['message'];
    }

    /**
     * @param array $response
     * @return Message
     */
    public function addResponse(array $response): Message
    {
        $date = new DateTime();
        $new_response['success'] = (bool)$response['ok'];
        $new_response['data'] = $response['result'];
        $new_response['date'] = $date->getTimestamp();
        $this->response[$date->getTimestamp()] = $new_response;
        return $this;
    }
}