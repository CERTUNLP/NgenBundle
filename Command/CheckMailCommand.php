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
use CertUnlp\NgenBundle\Entity\TelegramMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SecIT\ImapBundle\Service\Imap;

class CheckMailCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:email:check')
            ->setDescription('Check mails for the system.')
            ->addOption('chat_id', '-c', InputOption::VALUE_OPTIONAL, 'ChatId to write to.')
            ->addOption('token', '-t', InputOption::VALUE_OPTIONAL, 'Token to grant acces to chatid.')
            ->addOption('message', '-m', InputOption::VALUE_OPTIONAL, 'The message you want to send.', 'test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>[Messages]: Starting.</info>');
        $output->writeln('<info>[Messages]: Searching for new mail...</info>');
        $ngen_Connection = $this->getContainer()->get('secit.imap')->get('ngen_connection');
        $info = $ngen_Connection->getMailboxInfo();
        $output->writeln('<info>[Mails]: We found '. $info->Unread.' new messages...</info>');
        $emails = $ngen_Connection->searchMailBox('UNSEEN');
        //If the $emails variable is not a boolean FALSE value or
        //an empty array.
        if(!empty($emails)){
            //Loop through the emails.
            foreach($emails as $email){
                //echo $email;
                $subject= $ngen_Connection->getMailHeader($email)->subject;
                //echo $ngen_Connection->getRawMail($email,false);
                if (preg_match("/^Re\:/",$subject) && preg_match('/\[CERTUNLP\]/',$subject)){
                    preg_match('/\[ID:(?P<id>\d+)\]/',$subject,$incident_id);
                    //echo $incident_id['id']."\n";
                    $raw=$ngen_Connection->getMail($email,false);
                    $mensaje= preg_replace('#(^\w.+:\n)?(^>.*(\n|$))+#mi', '', $raw->textPlain);
                    print_r($raw);
                    print_r($raw);
                    //$from=$raw->FromName."<".$raw->FromAddress.">";
                    $incident_id['id']=134000;
                    $incident=$this->findIncidentToUpdate($incident_id['id']);
                    if ($incident){
                        echo $incident->getState();
                    }
                }
            }
        }
        $output->writeln('<info>[Messages]: Persisting sended messages.</info>');
        $this->getContainer()->get('doctrine')->getManager()->flush();
        $output->writeln('<info>[Messages]: Done.</info>');
    }


    /**
     * @return Incident
     */
    private function findIncidentToUpdate($id): ?Incident
    {
        return $this->getContainer()->get('doctrine')->getRepository(Incident::class)->findOneBy(['id'=>$id]);
    }

}
