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
use Symfony\Component\Console\Output\OutputInterface;

class IncidentNotificateCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:incidents:notificate')
            ->setDescription('Walk through incidents that have a date of 6 day ago or more and closes them.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Renotificating incidents...');
        $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->getToNotificateIncidents();
        foreach ($incidents as $incident) {
            $this->getContainer()->get('cert_unlp.ngen.incident.communication.mailer')->sendMail($incident);
        }
        $output->writeln('[incidents]: Done.');
    }

}
