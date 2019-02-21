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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TelegramCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:telegram:send')
            ->setDescription('Send a message to a Telegram chat.')
            ->addOption('chat_id', '-c', InputOption::VALUE_OPTIONAL, 'ChatId to write to.')
            ->addOption('token', '-t', InputOption::VALUE_OPTIONAL, 'Token to grant acces to chatid.')
            ->addOption('message', '-m', InputOption::VALUE_OPTIONAL, 'The message you want to send.', 'test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Sendind Telegram messages...');
        $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->renotificateIncidents();
        foreach ($incidents as $incident) {
            $incident->setRenotificationDate(New \DateTime());
            $this->getContainer()->get('cert_unlp.ngen.internal.incident.mailer')->send_report($incident, false, false, false, true);
            $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->patch($incident);
        }
        $output->writeln('[incidents]: Done.');
    }



    }

}
