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

use FOS\CommentBundle\Event\CommentPersistEvent;

class InternalIncidentMailer extends IncidentMailer {

    public function __construct(\Swift_Mailer $mailer, $templating, $cert_email, $upload_directory, $commentManager, $environment, $report_factory, $lang) {
        $this->reports_path = 'CertUnlpNgenBundle:InternalIncident:Report/Twig';
        parent::__construct($mailer, $templating, $cert_email, $upload_directory, $commentManager, $environment, $report_factory, $lang);
    }

    public function getMailSubject() {
        return '[CERTunlp] Incidente de tipo "%s" en el host %s [ID:%s]';
    }

    public function onCommentPrePersist(CommentPersistEvent $event) {
        if ($event->getComment()->getThread()->getIncident()->isInternal()) {
            parent::onCommentPrePersist($event);
        }
        return null;
    }

}
