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

class ChangeDueToInactivityCommand extends ContainerAwareCommand
{

    public function configure()
    {
        $this
            ->setName('cert_unlp:incidents:change-due-to-inactivity')
            ->setDescription('Walk through incidents to make an automatic close.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Change state of old incidents...');

        $unattended = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->closeUnattendedIncidents();
        $output->writeln('[incidents]: Changed unattended incidents: ' . count($unattended[0]));
        foreach ($unattended[0] as $incident) {
            $output->writeln('[incidents]: Changed incident id: ' . $incident['id'] . ' to state' . $incident['newState']);
        }
        $output->writeln('[incidents]: Could NOT change unattended incidents: ' . count($unattended[1]));
        foreach ($unattended[1] as $incident) {
            $output->writeln('[incidents]: Not Changed incident id: ' . $incident['id'] . ' form state ' . $incident['actualState'] . ' to state' . $incident['requiredState']);
        }
        $unsolved = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->closeUnsolvedIncidents();

        $output->writeln('[incidents]: Changed unsolved incidents: ' . count($unsolved[0]));
        foreach ($unsolved[0] as $incident) {
            $output->writeln('[incidents]: Changed incident id: ' . $incident['id'] . ' to state' . $incident['newState']);
        }
        $output->writeln('[incidents]: Could NOT change unsolved incidents: ' . count($unsolved[1]));
        foreach ($unsolved[1] as $incident) {
            $output->writeln('[incidents]: Not Changed incident id: ' . $incident['id'] . ' form state ' . $incident['actualState'] . ' to state' . $incident['requiredState']);
        }
        $output->writeln('[incidents]: Done.');
    }

}
