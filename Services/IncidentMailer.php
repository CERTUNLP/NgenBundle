<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Model\IncidentMailerInterface;
use CertUnlp\NgenBundle\Services\Delegator\DelegateInterface;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;

class IncidentMailer implements IncidentMailerInterface {

    private $mailer;
    private $cert_email;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, $templating, $cert_email, $upload_directory, CommentManagerInterface $commentManager) {
        $this->mailer = $mailer;
        $this->cert_email = $cert_email;
        $this->templating = $templating;
        $this->upload_directory = $upload_directory;
        $this->reports_path = '@incidents_reports';
        $this->commentManager = $commentManager;
    }

    public function getBody(IncidentInterface $incident, $type = 'html') {
        $parameters = array('incident' => $incident, 'txtOrHtml' => $type);
        $template = $incident->getReportEdit() ? $incident->getReportEdit() : $this->reports_path . '/' . $incident->getType()->getSlug() . 'Report.html.twig';
        return $this->templating->render($template, $parameters);
    }

    public function getReplyBody(IncidentInterface $incident, $body = '', $type = 'html') {
        $parameters = array('incident' => $incident, 'body' => $body, 'txtOrHtml' => $type);
        $template = $this->reports_path . '/reportReply.html.twig';
        return $this->templating->render($template, $parameters);
    }

    public function send_report(IncidentInterface $incident, $body = null, $echo = null) {
        if (!$echo) {
            if ($incident->getSendReport()) {
                $html = $this->getBody($incident);
                $text = strip_tags($this->getBody($incident, 'txt'));
                $message = \Swift_Message::newInstance()
                        ->setSubject(sprintf('[CERTunlp] Incidente de tipo "%s" en el host %s [ID:%s]', $incident->getType()->getName(), $incident->getHostAddress(), $incident->getId()))
                        ->setFrom($this->cert_email)
                        ->setCc($this->cert_email)
                        ->setTo($incident->getNetworkAdmin()->getEmail())
                        ->setBody($text)
                        ->addPart($html, 'text/html');
                if ($incident->getEvidenceFilePath()) {
                    $message->attach(\Swift_Attachment::fromPath($this->upload_directory . $incident->getEvidenceFilePath(true)));
                }
                if ($incident->getReportMessageId()) {
                    $message->setId($incident->getReportMessageId());
                }
                $this->mailer->send($message);
            }
        } else {
            $html = $this->getBody($incident);
            echo $html;
        }
    }

    public function send_report_reply(IncidentInterface $incident, $body = '', $self_reply = true) {

        $html = $this->getReplyBody($incident, $body);
        $text = strip_tags($this->getReplyBody($incident, $body, 'txt'));
        $message = \Swift_Message::newInstance()
                ->setSubject(sprintf('Comment:[CERTunlp] Incidente de tipo "%s" en el host %s [ID:%s]', $incident->getType()->getName(), $incident->getHostAddress(), $incident->getId()))
                ->setFrom($this->cert_email)
                ->setBody($text)
                ->addPart($html, 'text/html');

        if ($self_reply) {
            $message
                    ->setTo($this->cert_email);
        } else {
            $message
                    ->setTo($incident->getNetworkAdmin()->getEmail())
                    ->setCc($this->cert_email);
        }

        $message->getHeaders()->addTextHeader('References', $incident->getReportMessageId());
        $message->getHeaders()->addTextHeader('In-Reply-To', $incident->getReportMessageId());

        $this->mailer->send($message);
    }

    public function postPersistDelegation($incident) {
        $this->send_report($incident);
    }

    public function prePersistDelegation($incident) {
        $message = \Swift_Message::newInstance();
        $incident->setReportMessageId($message->getId());
    }

    public function postUpdateDelegation($incident) {
        $this->send_report($incident);
    }

    public function onCommentPrePersist(CommentPersistEvent $event) {
        $comment = $event->getComment();
//        var_dump($comment->getNotifyToAdmin());
//        die;
        if (!$this->commentManager->isNewComment($comment)) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
        }
        $this->send_report_reply($comment->getThread()->getIncident(), $comment->getBody(), !$comment->getNotifyToAdmin());
    }

}
