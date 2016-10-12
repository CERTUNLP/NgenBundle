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

use CertUnlp\NgenBundle\Model\IncidentInterface;
use FOS\CommentBundle\Event\CommentPersistEvent;

/**
 *
 * @author demyen
 */
interface IncidentMailerInterface {

    public function send_report(IncidentInterface $incident, $body = null, $echo = null, $is_new_incident = FALSE);

    public function getMailSubject();

    public function getBody(IncidentInterface $incident, $type = 'html');

    public function getReplyBody(IncidentInterface $incident, $body = '', $type = 'html');

    public function send_report_reply(IncidentInterface $incident, $body = '', $self_reply = true);

    public function onCommentPrePersist(CommentPersistEvent $event);
}
