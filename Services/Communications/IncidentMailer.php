<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Communications;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Services\IncidentReportFactory;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class IncidentMailer extends IncidentCommunication
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
    private $translator;


    public function __construct(EntityManagerInterface $doctrine, \Swift_Mailer $mailer, \Twig_Environment $templating, string $cert_email, string $upload_directory, CommentManagerInterface $commentManager, string $environment, IncidentReportFactory $report_factory, string $lang, array $team, Translator $translator)
    {
        parent::__construct($doctrine);
        $this->mailer = $mailer;
        $this->cert_email = $cert_email;
        $this->templating = $templating;
        $this->upload_directory = $upload_directory;
        $this->commentManager = $commentManager;
        $this->environment = in_array($environment, ['dev', 'test']) ? '[dev]' : '';
        $this->report_factory = $report_factory;
        $this->lang = $lang;
        $this->team = $team;
        $this->translator = $translator;
    }

    /**
     * @param Incident $incident
     * @return void
     */
    public function comunicate(Incident $incident): void
    {
        $this->sendMail($incident);
    }

    public function sendMail(Incident $incident, $body = null, $echo = null, $is_new_incident = false, $renotification = false)
    {
        $emails = $this->getEmails($incident);
        if ($emails) {
            #Hay que discutir si es necesario mandar cualquier cambio o que cosa todo || $is_new_incident || $renotification) {
            $html = $this->getBody($incident);
            $message = \Swift_Message::newInstance()
                ->setSubject(sprintf($this->mailSubject($renotification), $incident->getTlp(), $this->team['name'], $incident->getType()->getName(), $incident->getAddress(), $incident->getId()))
                ->setFrom($this->cert_email)
                ->setSender($this->cert_email)
                ->setTo($emails)
                ->addPart($html, 'text/html');

            if ($incident->getEvidenceFilePath()) {
                $message->attach(\Swift_Attachment::fromPath($this->upload_directory . $incident->getEvidenceFilePath(true)));
            }

            if ($incident->getReportMessageId()) {
                $message->setId($incident->getReportMessageId());
            }

            return $this->mailer->send($message);
        }
        return null;
    }

    public function getBody(Incident $incident, string $type = 'html')
    {
        return $this->report_factory->getReport($incident, $this->lang);
    }

    public function mailSubject(bool $renotification = false)
    {
        return $this->environment . $this->getMailSubject($renotification);
    }

    public function getMailSubject(bool $renotification = false): string
    {
        $renotification_text = $renotification ? '[' . $this->translator->trans('subject_mail_renotificacion') . ']' : '';
        return $renotification_text . '[TLP:%s][%s] ' . $this->translator->trans('subject_mail_incidente') . ' [ID:%s]';
    }

    public function prePersistDelegation(Incident $incident)
    {
        $message = \Swift_Message::newInstance();
        $incident->setReportMessageId($message->getId());
    }

    public function onCommentPrePersist(CommentPersistEvent $event)
    {
        $comment = $event->getComment();

        if (!$this->commentManager->isNewComment($comment)) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUsername() === 'mailbot') {
                return;
            }
        }
        $this->send_report_reply($comment->getThread()->getIncident(), $comment->getBody(), !$comment->getNotifyToAdmin());
    }

    public function send_report_reply(Incident $incident, string $body = '', bool $self_reply = true)
    {

        $html = $this->getReplyBody($incident, $body);
        $message = \Swift_Message::newInstance()
            ->setSubject(sprintf($this->replySubject(), $incident->getTlp(), $this->team['name'], $incident->getType()->getName(), $incident->getAddress(), $incident->getId()))
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

    public function getReplyBody(Incident $incident, string $body = '')
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
