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
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Communication\Message\Message;
use CertUnlp\NgenBundle\Entity\Communication\Message\MessageEmail;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Service\IncidentReportFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CommentBundle\Model\CommentManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;

class IncidentCommunicationMailer extends IncidentCommunication
{
    /**
     * @var string
     */
    private $environment;
    /**
     * @var string
     */
    private $lang;
    /**
     * @var string
     */
    private $team_name;
    /**
     * @var string
     */
    private $evidence_path;
    /**
     * @var IncidentReportFactory
     */
    private $report_factory;

    public function __construct(EntityManagerInterface $doctrine, CommentManagerInterface $commentManager, TranslatorInterface $translator, string $environment, string $ngen_lang, string $ngen_team_name, string $evidence_path, IncidentReportFactory $report_factory)
    {
        parent::__construct($doctrine, $commentManager, $translator);
        $this->evidence_path = $evidence_path;
        $this->report_factory = $report_factory;
        $this->environment = in_array($environment, ['dev', 'test']) ? '[dev]' : '';
        $this->lang = $ngen_lang;
        $this->team_name = $ngen_team_name;
    }

    /**
     * @param Incident $incident
     * @return ArrayCollection|ContactTelegram[]
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
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function createDataJson(Incident $incident, ?Contact $contact): array
    {
        $data = parent::createDataJson($incident, $contact);
        $data['body'] = $this->getBody($incident);
        $data['subject'] = sprintf($this->mailSubject(false), $incident->getTlp(), $this->getTeamName(), $incident->getType()->getName(), $incident->getAddress(), $incident->getId());
        $data['evidence_files'] = $this->getEvidenceFiles($incident);

        return $data;
    }

    /**
     * @param Incident $incident
     * @return string|null
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function getBody(Incident $incident): ?string
    {
        return $this->getReportFactory()->getReport($incident, $this->getLang());
    }

    /**
     * @return IncidentReportFactory
     */
    public function getReportFactory(): IncidentReportFactory
    {
        return $this->report_factory;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param bool $renotification
     * @return string
     */
    public function mailSubject(bool $renotification = false): string
    {
        return $this->getEnvironment() . $this->getMailSubject($renotification);
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param bool $renotification
     * @return string
     */
    public function getMailSubject(bool $renotification = false): string
    {
        $renotification_text = $renotification ? '[' . $this->getTranslator()->trans('subject_mail_renotificacion') . ']' : '';
        return $renotification_text . '[TLP:%s][%s] ' . $this->getTranslator()->trans('subject_mail_incidente') . ' [ID:%s]';
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
     * @param Incident $incident
     * @return string
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function getDataMessage(Incident $incident): string
    {
        return $this->getBody($incident);
    }
}
