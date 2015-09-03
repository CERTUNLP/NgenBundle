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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IncidentRenotificateCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cert_unlp:incidents:renotificate')
                ->setDescription('Walk through incidents that have a date of 6 day ago or more and closes them.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Renotificating incidents...');
        $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.handler')->renotificateIncidents();
        var_dump($incidents);
        die;
//        foreach ($incidents as $incident) {
//            $incident->setSendReport(true);
//            $this->getContainer()->get('cert_unlp.incident.mailer')->send_report($incident);
//        }
        $output->writeln('[incidents]: Done.');
    }

}
