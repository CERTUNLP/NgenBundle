<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Communications;

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Communication\Message\Message;
use CertUnlp\NgenBundle\Entity\Communication\Message\MessageEmail;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentComment;
use CertUnlp\NgenBundle\Service\IncidentLangFactory;
use CertUnlp\NgenBundle\Service\IncidentReportFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CommentBundle\Model\CommentManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class IncidentCommunicationMailer extends IncidentCommunication
{
    /**
     * @var string
     */
    private string $environment;
    /**
     * @var string
     */
    private string $team_name;
    /**
     * @var string
     */
    private string $evidence_path;
    /**
     * @var IncidentReportFactory
     */
    private IncidentReportFactory $report_factory;
    /**
     * @var IncidentLangFactory
     */
    private IncidentLangFactory $incident_lang_factory;

    public function __construct(EntityManagerInterface $doctrine, CommentManagerInterface $commentManager, TranslatorInterface $translator, string $environment, string $ngen_team_name, string $evidence_path, IncidentReportFactory $report_factory, IncidentLangFactory $incident_lang_factory)
    {
        parent::__construct($doctrine, $commentManager, $translator);
        $this->evidence_path = $evidence_path;
        $this->report_factory = $report_factory;
        $this->environment = in_array($environment, ['dev', 'test']) ? '[dev]' : '';
        $this->team_name = $ngen_team_name;
        $this->incident_lang_factory = $incident_lang_factory;
    }

    /**
     * @param Incident $incident
     * @return void
     */
    public function comunicate(Incident $incident): void
    {
        $contacts = $this->getContacts($incident);
        if ($contacts) {
            $message = $this->createMessage();
            $message->setData($this->createDataJson($incident));
            $message->setIncident($incident);
            $message->setPending(true);
            if (!$message->isEmpty()) {
                $this->getDoctrine()->persist($message);
            }
            $this->getDoctrine()->flush();
        }
    }

    /**
     * @param Incident $incident
     * @return ArrayCollection|ContactEmail[]
     */
    public function getContacts(Incident $incident): ArrayCollection
    {
        return $incident->getEmailContacts();
    }

    /**
     * @return Message
     */
    public function createMessage(): Message
    {
        return new MessageEmail();
    }

    /**
     * @param Incident $incident
     * @param Contact|null $contact
     * @return array
     */
    public function createDataJson(Incident $incident, ?Contact $contact = null): array
    {
        $data = parent::createDataJson($incident, $contact);
        $data['body'] = $this->getBody($incident);
        $data['subject'] = sprintf($this->mailSubject($this->getIncidentLangFactory()->getLangByIncident($incident)), $incident->getTlp(), $this->getTeamName(), $incident->getType()->getName(), $incident->getAddress(), $incident->getId());
        $data['evidence_files'] = $this->getEvidenceFiles($incident);
        $data['notify_admin'] = true;

        return $data;
    }

    /**
     * @param Incident $incident
     * @return string|null
     */
    public function getBody(Incident $incident): ?string
    {
        return $this->getReportFactory()->getReport($incident);
    }

    /**
     * @return IncidentReportFactory
     */
    public function getReportFactory(): IncidentReportFactory
    {
        return $this->report_factory;
    }

    /**
     * @param string $lang
     * @param bool $renotification
     * @return string
     */
    public function mailSubject(string $lang, bool $renotification = false): string
    {
        return $this->getEnvironment() . $this->getMailSubject($lang, $renotification);
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param string $lang
     * @param bool $renotification
     * @return string
     */
    public function getMailSubject(string $lang, bool $renotification = false): string
    {
        $renotification_text = $renotification ? '[' . $this->getTranslator()->trans('subject_mail_renotificacion', [], null, $lang) . ']' : '';
        return $renotification_text . '[TLP:%s][%s] ' . $this->getTranslator()->trans('subject_mail_incidente', [], null, $lang) . ' [ID:%s]';
    }

    /**
     * @return IncidentLangFactory
     */
    public function getIncidentLangFactory(): IncidentLangFactory
    {
        return $this->incident_lang_factory;
    }

    /**
     * @return string
     */
    public function getTeamName(): string
    {
        return $this->team_name;
    }

    private function getEvidenceFiles(Incident $incident): array
    {
        $evidence_path = $this->getEvidencePath() . "/";
        $evidence_files = [];
        foreach ($incident->getIncidentsDetected() as $detected) {
            if ($detected->getEvidenceFilePath() && file_exists($evidence_path . $detected->getEvidenceFilePath())) {
                $evidence_files[] = $evidence_path . $detected->getEvidenceFilePath();
            }
        }
        return $evidence_files;
    }

    /**
     * @return string
     */
    public function getEvidencePath(): string
    {
        return $this->evidence_path;
    }

    /**
     * @param IncidentComment $comment
     * @return void
     */
    public function comunicate_comment(IncidentComment $comment): void
    {
        $incident = $comment->getThread()->getIncident();
        $contacts = $this->getContacts($incident);
        if ($contacts) {
            $message = $this->createMessage();
            $message->setData($this->createCommentDataJson($comment));
            $message->setIncident($incident);
            $message->setPending(true);
            if (!$message->isEmpty()) {
                $this->getDoctrine()->persist($message);
            }
            $this->getDoctrine()->flush();
        }
    }

    /**
     * @param IncidentComment $comment
     * @param Contact|null $contact
     * @return array
     */
    public function createCommentDataJson(IncidentComment $comment, Contact $contact = null): array
    {
        $data = parent::createCommentDataJson($comment, $contact);
        $incident = $comment->getThread()->getIncident();
        $data['body'] = $this->getReplyBody($comment);
        $data['subject'] = sprintf($this->replySubject(), $incident->getTlp(), $this->getTeamName(), $incident->getType()->getName(), $incident->getAddress(), $incident->getId());
        $data['evidence_files'] = [];
        $data['notify_admin'] = $comment->getNotifyToAdmin();

        return $data;
    }

    /**
     * @param IncidentComment $comment
     * @return string|null
     */
    public function getReplyBody(IncidentComment $comment): ?string
    {
        return $this->getReportFactory()->getReportReply($comment->getThread()->getIncident(), $comment->getBody());

    }

    /**
     * @return string
     */
    public function replySubject(): string
    {
        return 'Comment:' . $this->mailSubject();
    }

    /**
     * @param Incident $incident
     * @return string
     */
    public function getDataMessage(Incident $incident): ?string
    {
        return $this->getBody($incident);
    }

    /**
     * @param IncidentComment $comment
     * @return string
     */
    public function getCommentDataMessage(IncidentComment $comment): ?string
    {
        return $this->getReplyBody($comment);
    }
}
