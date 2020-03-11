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
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use ZipArchive;

class IncidentMailer extends IncidentCommunication
{

    protected $mailer;
    protected $cert_email;
    protected $upload_directory;
    protected $report_factory;


    public function __construct(EntityManagerInterface $doctrine, CommentManagerInterface $commentManager, string $environment, string $lang, array $team, Translator $translator, Swift_Mailer $mailer, string $cert_email, IncidentReportFactory $report_factory, string $upload_directory)
    {
        parent::__construct($doctrine, $commentManager, $environment, $lang, $team, $translator);
        $this->mailer = $mailer;
        $this->cert_email = $cert_email;
        $this->upload_directory = $upload_directory;
        $this->report_factory = $report_factory;
    }

    public function prePersistDelegation(Incident $incident)
    {
        $message = Swift_Message::newInstance();
        $incident->setReportMessageId($message->getId());
    }

    /**
     * @param Incident $incident
     * @return void
     */
    public function comunicate(Incident $incident): void
    {
        $this->sendMail($incident);
    }

    public function sendMail(Incident $incident, bool $renotification = false)
    {
        $emails = [];

        if ($incident->getStateEdge()->getMailTeam()->getLevel() >= $incident->getPriority()->getCode()) {
            $emails = array($this->cert_email);
        }

        $emails = array_merge($emails, $incident->getEmails());
        if ($emails) {
            $html = $this->getBody($incident);
            $message = Swift_Message::newInstance()
                ->setSubject(sprintf($this->mailSubject($incident, $renotification), $incident->getTlp(), $this->team['name'], $incident->getType()->getName(), $incident->getAddress(), $incident->getId()))
                ->setFrom($this->cert_email)
                ->setSender($this->cert_email)
                ->setTo($emails)
                ->addPart($html, 'text/html');
            $evidence_path = $this->upload_directory . '/';

            foreach ($incident->getIncidentsDetected() as $detected) {
                if ($detected->getEvidenceFilePath()) {
                    if (file_exists($evidence_path . $detected->getEvidenceFilePath())) {
                        $message->attach(\Swift_Attachment::fromPath($evidence_path . $detected->getEvidenceFilePath()));
                    } else {
                        $detected->setEvidenceFilePath(null);
                    }
                }
            }
            if ($incident->getReportMessageId()) {
                $message->setId($incident->getReportMessageId());
            }

            return $this->mailer->send($message);
        }
        return null;
    }

    /**
     * @param Incident $incident
     * @param string $type
     * @return false|string
     */
    public function getBody(Incident $incident, string $type = 'html')
    {
        return $this->report_factory->getReport($incident, $this->lang);
    }

    public function mailSubject(Incident $incident, bool $renotification = false)
    {
        return $this->environment . $this->getMailSubject($incident, $renotification);
    }

    public function getMailSubject(Incident $incident, bool $renotification = false): string
    {
        $renotification_text = $renotification ? '[' . $this->translator->trans('subject_mail_renotificacion') . ']' : '';
        return $renotification_text . '[TLP:%s][%s] ' . $this->translator->trans('subject_mail_incident_' . strtolower($incident->getStateEdge())) . ' [ID:%s]';
    }

    public function getEvidenceFileName(Incident $incident)
    {

        // Create new Zip Archive.
        $zip = new ZipArchive();

        // The name of the Zip documents.
        $evidence_path = $this->upload_directory . $incident->getEvidenceSubDirectory() . "/";
        $zipName = $evidence_path . 'EvidenceDocuments' . $incident->__toString() . '.zip';
        $options = array('remove_all_path' => TRUE);
        $zip->open($zipName, ZipArchive::CREATE);
        foreach ($incident->getIncidentsDetected() as $detected) {
            if ($detected->getEvidenceFilePath()) {
                $zip->addFile($evidence_path . $detected->getEvidenceFilePath(), $detected->getEvidenceFilePath());
            }
        }
        //$zip->addGlob($evidence_path . "*", GLOB_BRACE, $options);
        $zip->close();

        return $zipName;
    }

    public function onCommentPrePersist(CommentPersistEvent $event)
    {
        $comment = $event->getComment();
        if (!$this->commentManager->isNewComment($comment) || !$comment->getThread()->getIncident()->canCommunicateComment()) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUserName() === 'mailbot') {
                return;
            }
        }
        $this->comunicate_reply($comment->getThread()->getIncident(), $comment->getBody(), $comment->getNotifyToAdmin());
    }

    public function comunicate_reply(Incident $incident, string $body = '', bool $notify_to_admins = true)
    {

        $html = $this->getReplyBody($incident, $body);
        $message = Swift_Message::newInstance()
            ->setSubject(sprintf($this->replySubject(), $incident->getTlp(), $this->team['name'], $incident->getType()->getName(), $incident->getAddress(), $incident->getId()))
            ->setFrom($this->cert_email)
            ->addPart($html, 'text/html');

        if ($notify_to_admins) {
            $message
                ->setTo($incident->getEmails())
                ->setCc($this->cert_email);
        } else {
            $message
                ->setTo($this->cert_email);
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
