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
use CertUnlp\NgenBundle\Services\IncidentReportFactory;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;

class IncidentMailer implements IncidentMailerInterface
{

    protected $mailer;
    protected $cert_email;
    protected $templating;
    protected $upload_directory;
    protected $reports_path;
    protected $commentManager;
    protected $environment;
    protected $report_factory;
    protected $lang;
    protected $team;



    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, string $cert_email, string $upload_directory, CommentManagerInterface $commentManager, string $environment, IncidentReportFactory $report_factory, string $lang, $team, $translator)
    {
        $this->mailer = $mailer;
        $this->cert_email = $cert_email;
        $this->templating = $templating;
        $this->upload_directory = $upload_directory;
        $this->commentManager = $commentManager;
        $this->environment = (in_array($environment, ['dev', 'test'])) ? '[dev]' : '';
        $this->report_factory = $report_factory;
        $this->lang = $lang;
        $this->team = $team;
        $this->translator = $translator;
    }

    public function postPersistDelegation($incident)
    {
        $this->send_report($incident, null, null, TRUE);
    }

    /**
     * @param IncidentInterface $incident
     * @param null $body
     * @param null $echo
     * @param bool $is_new_incident
     * @param bool $renotification
     * @return int
     */
    public function send_report(IncidentInterface $incident, $body = null, $echo = null, $is_new_incident = FAlSE, $renotification = false)
    {
        if (!$echo) {
            if ($incident->getSendReport() || $is_new_incident || $renotification) {
                $html = $this->getBody($incident);
                $message = \Swift_Message::newInstance()
                    ->setSubject(sprintf($this->mailSubject($renotification), $incident->getTlpState(),$this->team["name"],$incident->getType()->getName(),$incident->getHostAddress(), $incident->getId()))
                    ->setFrom($this->cert_email)
                    ->setCc($this->cert_email)
                    ->setSender($this->cert_email)
                    ->setTo($incident->getEmails())
                    ->addPart($html, 'text/html');

                if ($incident->getEvidenceFilePath()) {
                    $message->attach(\Swift_Attachment::fromPath($this->upload_directory . $incident->getEvidenceFilePath(true)));
                }

                if ($incident->getReportMessageId()) {
                    $message->setId($incident->getReportMessageId());
                }

                return $this->mailer->send($message);
            }
        } else {
            $html = $this->getBody($incident);
            return $html;
        }
        return null;
    }

    public function getBody(IncidentInterface $incident, $type = 'html')
    {
        return $this->report_factory->getReport($incident, $this->lang);
    }

    public function mailSubject($renotification = false)
    {
        return $this->environment . $this->getMailSubject($renotification);
    }

    public function getMailSubject($renotification = false)
    {
        return '';
    }

    public function prePersistDelegation(IncidentInterface $incident)
    {
        $message = \Swift_Message::newInstance();
        $incident->setReportMessageId($message->getId());
    }

    public function postUpdateDelegation($incident)
    {
        $this->send_report($incident);
    }

    public function onCommentPrePersist(CommentPersistEvent $event)
    {
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

    public function send_report_reply(IncidentInterface $incident, $body = '', $self_reply = true)
    {

        $html = $this->getReplyBody($incident, $body);
        $message = \Swift_Message::newInstance()
            ->setSubject(sprintf($this->replySubject(), $incident->getType()->getName(), $incident->getHostAddress(), $incident->getId()))
            ->setFrom($this->cert_email)
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

    public function getReplyBody(IncidentInterface $incident, $body = '')
    {
        return $this->report_factory->getReportReply($incident, $body, $this->lang);

    }

    public function replySubject()
    {
        return 'Comment:' . $this->mailSubject();
    }

    public function getReplySubject()
    {
        return '';
    }

}
