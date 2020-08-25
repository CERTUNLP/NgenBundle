<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Communication\Message;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author einar
 * @ORM\Entity()
 */
class MessageEmail extends Message
{
    /**
     * @param array $response
     * @return Message
     */
    public function addResponse(array $response): Message
    {
        $date = new DateTime();
        $new_response['success'] = (bool)$response['success'];
        $new_response['data'] = $response['errors'];
        $new_response['date'] = $date->getTimestamp();
        $this->response[$date->getTimestamp()] = $new_response;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'envelope';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->getData()['body'];
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->getData()['subject'];
    }

    /**
     * @return bool
     */
    public function isNotifyToAdmin(): bool
    {
        return $this->getData()['notify_admin'];
    }

    /**
     * @return array
     */
    public function getEvidenceFiles(): array
    {
        return $this->getData()['evidence_files'];
    }

}