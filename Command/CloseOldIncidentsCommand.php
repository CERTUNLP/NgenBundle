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

class CloseOldIncidentsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:incidents:close-by-inactivity')
            ->setDescription('Walk through incidents to make an automatic close.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Closing old incidents...');
        $output->writeln('[incidents]: Closed unsolved incidents: ' . count($this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->closeUnsolvedIncidents()));
        $output->writeln('[incidents]: Closed unsolved incidents: ' . count($this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->closeUnattendedIncidents()));
        $output->writeln('[incidents]: Done.');
    }

}
