<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Mailer;

use CertUnlp\NgenBundle\Entity\Incident\Incident;

/**
 *
 * @author demyen
 */
interface IncidentMailerInterface
{

    public function send_report(Incident $incident, $body = null, $echo = null, $is_new_incident = FALSE);

    public function getMailSubject(bool $renotification = false);

    public function getReplySubject();

    public function getBody(Incident $incident, string $type = 'html');

    public function getReplyBody(Incident $incident, string $body = '');

    public function send_report_reply(Incident $incident, string $body = '', bool $self_reply = true);

    public function onCommentPrePersist(Incident $event);
}
