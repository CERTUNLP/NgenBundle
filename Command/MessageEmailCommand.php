<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Command;

use CertUnlp\NgenBundle\Entity\Communication\Message\MessageEmail;
use CertUnlp\NgenBundle\Repository\Communication\Message\MessageEmailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessageEmailCommand extends ContainerAwareCommand
{
    /**
     * @var MessageEmailRepository
     */
    private $email_repository;
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $ngen_team_mail;

    public function __construct(MessageEmailRepository $email_repository, EntityManagerInterface $doctrine, Swift_Mailer $mailer, string $ngen_team_mail)
    {
        parent::__construct(null);
        $this->email_repository = $email_repository;
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
        $this->ngen_team_mail = $ngen_team_mail;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:message:email:send')
            ->setDescription('Sends messages via email');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[message][email]: Starting.');
        $limit = 50;
        $offset = 0;
        $messages = $this->getEmailRepository()->findByPending(true);
        while ($messages) {
            $output->write('[message][email]:<info> Found ' . count($messages) . ' messages to send.</info>');
            $output->writeln('<info>Total analyzed ' . $offset . '</info>');
            foreach ($messages as $message) {
                $output->write('<comment>[message][email]: sending message(' . $message->getId() . ') </comment>');
                $decode_result = $this->sendMail($message);
                if ($decode_result['success']) {
                    $message->addResponse($decode_result);
                    $message->setPending(false);
                    $output->writeln('<info>...sended. </info>');
                } else {
                    $message->addResponse($decode_result);
                    $output->writeln('<error>...error: ' . $decode_result['description'] . '</error>');
                }
                $this->getDoctrine()->persist($message);
            }
            $offset += $limit;
            $output->writeln('<info>[message][email]: Persisting sended messages.</info>');
            $this->getDoctrine()->flush();
            $output->writeln('<info>[message][email]: Done.</info>');
            $messages = $this->getEmailRepository()->findByPending(true);
        }
        $output->writeln('[message][email]: Finished.');
    }

    /**
     * @return MessageEmailRepository
     */
    public function getEmailRepository(): MessageEmailRepository
    {
        return $this->email_repository;
    }

    /**
     * @param MessageEmail $message_email
     * @return array|null
     */
    public function sendMail(MessageEmail $message_email): ?array
    {
        $emails = [];

        if ($message_email->getIncident()->getStateEdge()->getMailTeam()->getLevel() >= $message_email->getIncident()->getPriority()->getCode()) {
            $emails = array($this->getNgenTeamMail());
        }

        $emails = array_merge($emails, $message_email->getIncident()->getEmails());
        if ($emails) {
            $html = $message_email->getData()['body'];
            $message = Swift_Message::newInstance()
                ->setSubject($message_email->getData()['subject'])
                ->setFrom($this->getNgenTeamMail())
                ->setSender($this->getNgenTeamMail())
                ->setTo($emails)
                ->addPart($html, 'text/html');

            foreach ($message_email->getData()['evidence_files'] as $evidence_file) {
                $message->attach(Swift_Attachment::fromPath($evidence_file));
            }
            if ($message_email->getIncident()->getReportMessageId()) {
                $message->setId($message_email->getIncident()->getReportMessageId());
            }
            $errors = [];
            $respose = $this->getMailer()->send($message, $errors);
            return ['success' => $respose, 'errors' => $errors];
        }
        return null;
    }

    /**
     * @return string
     */
    public function getNgenTeamMail(): string
    {
        return $this->ngen_team_mail;
    }

    /**
     * @return Swift_Mailer
     */
    public function getMailer(): Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getDoctrine(): EntityManagerInterface
    {
        return $this->doctrine;
    }

}
