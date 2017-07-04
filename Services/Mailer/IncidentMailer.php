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

use CertUnlp\NgenBundle\Services\Delegator\DelegateInterface;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;

class IncidentMailer implements IncidentMailerInterface {

    protected $mailer;
    protected $cert_email;
    protected $templating;
    protected $upload_directory;
    protected $reports_path;
    protected $commentManager;
    protected $environment;

    public function __construct(\Swift_Mailer $mailer, $templating, $cert_email, $upload_directory, $incident_openpgpsigner, CommentManagerInterface $commentManager, $environment) {
        $this->mailer = $mailer;
        $this->cert_email = $cert_email;
        $this->templating = $templating;
        $this->upload_directory = $upload_directory;
        $this->incident_openpgpsigner = $incident_openpgpsigner;
        $this->commentManager = $commentManager;
        $this->environment = (in_array($environment, ['dev', 'test'])) ? '[dev]' : '';
    }

    public function getBody(IncidentInterface $incident, $type = 'html') {
        $parameters = array('incident' => $incident, 'txtOrHtml' => $type);
        if ($incident->getReportEdit()) {
            return $this->templating->createTemplate($incident->getReportEdit())->render($parameters);
        } else {
            $template = $this->reports_path . '/' . $incident->getType()->getSlug() . 'Report.html.twig';
            return $this->templating->render($template, $parameters);
        }
    }

    public function getReplyBody(IncidentInterface $incident, $body = '', $type = 'html') {
        $parameters = array('incident' => $incident, 'body' => $body, 'txtOrHtml' => $type);
        $template = $this->reports_path . '/reportReply.html.twig';
        return $this->templating->render($template, $parameters);
    }

    public function send_report(IncidentInterface $incident, $body = null, $echo = null, $is_new_incident = FAlSE) {
        if (!$echo) {
            if ($incident->getSendReport() || $is_new_incident) {
                $html = $this->getBody($incident);
                $text = strip_tags($this->getBody($incident, 'txt'));
                $message = \Swift_Message::newInstance()
                        ->setSubject(sprintf($this->mailSubject(), $incident->getType()->getName(), $incident->getHostAddress(), $incident->getId()))
                        ->setFrom($this->cert_email)
                        ->setCc($this->cert_email)
                        ->setSender($this->cert_email)
                        ->setTo($incident->getEmails())
                        ->setBody($text)
                        ->addPart($html, 'text/html');
                $this->incident_openpgpsigner->sign($message, true);

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
                ->setSubject(sprintf($this->replySubject(), $incident->getType()->getName(), $incident->getHostAddress(), $incident->getId()))
                ->setFrom($this->cert_email)
                ->setBody($text)
                ->addPart($html, 'text/html');

        if ($self_reply) {
            $message
                    ->setTo($this->cert_email);
        } else {
            $message
                    ->setTo($incident->getEmails())
                    ->setCc($this->cert_email);
        }

        $message->getHeaders()->addTextHeader('References', $incident->getReportMessageId());
        $message->getHeaders()->addTextHeader('In-Reply-To', $incident->getReportMessageId());

        $this->mailer->send($message);
    }

    public function postPersistDelegation($incident) {
        $this->send_report($incident, null, null, TRUE);
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

        if (!$this->commentManager->isNewComment($comment)) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUsername() == 'mailbot') {
                return;
            }
        }
        $this->send_report_reply($comment->getThread()->getIncident(), $comment->getBody(), !$comment->getNotifyToAdmin());
    }

    public function mailSubject() {
        return $this->environment . $this->getMailSubject();
    }

    public function replySubject() {
        return 'Comment:' . $this->mailSubject();
    }

    public function getMailSubject() {
        return '';
    }

    public function getReplySubject() {
        return '';
    }

}
