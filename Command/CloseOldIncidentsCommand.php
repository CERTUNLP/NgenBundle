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

class CloseOldIncidentsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:incidents:close-old')
            ->setDescription('Walk through incidents that have a date of 6 day ago or more and closes them.')
            ->addOption('days', '-d', InputOption::VALUE_OPTIONAL, 'Close incidents of days ago', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Closing old incidents...');
        $output->writeln('[incidents]: Internals...');
        $closedInternalIncidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->closeOldIncidents($input->getOption('days'));
        $output->writeln('[incidents]: Externals...');
        $closedExternalIncidents = $this->getContainer()->get('cert_unlp.ngen.incident.external.handler')->closeOldIncidents($input->getOption('days'));

        $output->writeln('[incidents]: Closed internal incidents: ' . count($closedInternalIncidents));
        $output->writeln('[incidents]: Closed external incidents: ' . count($closedExternalIncidents));
//        if ($output->isVerbose()) {
//            foreach ($closedIncidents as $id => $incident) {
//                $output->writeln('[incidents]: #' . $id . ' hostAdress: ' . $incident['hostAddress'] . ' type: ' . $incident['type'] . ' date: ' . $incident['hostAddress'] . ' lastTimeDetected:' . $incident['lastTimeDetected'] . ' openDays:' . $incident['openDays']);
//            }
//        }
        $output->writeln('[incidents]: Done.');
    }

}
