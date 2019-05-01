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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SecIT\ImapBundle\Service\Imap;
use CertUnlp\NgenBundle\Entity\User;

class CheckMailCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:email:check')
            ->setDescription('Check mails for the system.')
            ->addOption('connection', '-c', InputOption::VALUE_OPTIONAL, 'Connection to use.', 'ngen_connection')
            ->addOption('mailbot', '-u', InputOption::VALUE_OPTIONAL, 'User to use to insert comments', 'mailbot')
            ->addOption('mark', '-m', InputOption::VALUE_OPTIONAL, 'Mark mail as readed', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $input->getOption('connection');
        $mark = $input->getOption('mark');
        $mailbot = $input->getOption('mailbot');
        $output->writeln('<info>[Messages]: Starting.</info>');
        $output->writeln('<info>[Messages]: Searching for new mail...</info>');
        $ngen_Connection = $this->getContainer()->get('secit.imap')->get($connection);
        $comment_thread_manager = $this->getContainer()->get('fos_comment.manager.thread');
        $comment_manager = $this->getContainer()->get('fos_comment.manager.comment');
        $info = $ngen_Connection->getMailboxInfo();
        $output->writeln('<info>[Mails]: We found ' . $info->Unread . ' new messages...</info>');
        $emails = $ngen_Connection->searchMailBox('UNSEEN');
        //If the $emails variable is not a boolean FALSE value or
        //an empty array.
        $userMailbot = $this->findMailbotUser($mailbot);
        if (!$userMailbot) {
            $output->writeln('<error>[Mails]: No username ' . $mailbot . ' detected, you have to do it! </error>');
            die();
        }
        if (!empty($emails)) {
            //Loop through the emails.
            foreach ($emails as $email) {
                $output->writeln("<info>Procesando email con id " . $email . '<info>');
                $subject = $ngen_Connection->getMailHeader($email)->subject;
                if (preg_match("/^Re\:/", $subject) && preg_match('/\[CERTUNLP\]/', $subject)) {
                    preg_match('/\[ID:(?P<id>\d+)\]/', $subject, $incident_id);
                    $raw = $ngen_Connection->getMail($email, $mark);
                    $mensaje = preg_replace('#(^\w.+:\n)?(^>.*(\n|$))+#mi', '', $raw->textPlain);
                    $mensaje2 = explode("--", $mensaje);
                    $mensaje = substr($mensaje2[0], 0, strrpos($mensaje2[0], "\n"));
                    $mensaje3 = substr($mensaje, 0, strrpos($mensaje, "\n"));
                    $body = $raw->fromName . " <" . $raw->fromAddress . ">  answered: " . $mensaje3;
                    $incident = $this->findIncidentToUpdate($incident_id['id']);
                    if ($incident) {
                        $thread = $comment_thread_manager->findThreadById($incident_id['id']);
                        $comment = $comment_manager->createComment($thread);
                        $comment->setBody($body);
                        $comment->setAuthor($userMailbot);
                        $comment_manager->saveComment($comment);
                        $output->writeln('<info>[Messages]: Persisting comment for incident ' . $incident->getSlug() . ' messages.</info>');
                    } else {
                        $output->writeln('<error>[Messages]: The incident ' . $incident_id['id'] . ' does not exist.</error>');

                    }
                }
            }
        }
        $this->getContainer()->get('doctrine')->getManager()->flush();
        $output->writeln('<info>[Messages]: Done.</info>');
    }


    /**
     * @return Incident
     */
    private function findIncidentToUpdate($id): ?Incident
    {
        return $this->getContainer()->get('doctrine')->getRepository(Incident::class)->findOneBy(['id' => $id]);
    }

    /**
     * @return User
     */
    private function findMailbotUser($username): ?User
    {
        return $this->getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['username' => $username]);
    }

}
