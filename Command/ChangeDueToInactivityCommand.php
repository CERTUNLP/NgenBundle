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
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\IncidentHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeDueToInactivityCommand extends ContainerAwareCommand
{
    /**
     * @var IncidentHandler
     */
    private $incident_handler;

    public function __construct(IncidentHandler $incident_handler)
    {
        parent::__construct(null);
        $this->incident_handler = $incident_handler;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:incidents:change-due-to-inactivity')
            ->setDescription('Walk through incidents to make an automatic close.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: <info>Starting.</info>');
        $output->writeln('[incidents]: <info>Changing states of old incidents...</info>');

        [$unresponded_changed, $unresponded_not_changed] = $this->getIncidentHandler()->closeUnrespondedIncidents();
        $output->writeln('[incidents]: <info>Changed unresponded incidents: ' . count($unresponded_changed) . '</info>');
        foreach ($unresponded_changed as $incident) {
            $output->writeln($this->printChanged($incident));
        }
        $output->writeln('[incidents]: <comment>Could NOT change unresponded incidents: ' . count($unresponded_not_changed) . '</comment>');
        foreach ($unresponded_not_changed as $incident) {
            $output->writeln($this->printUnchanged($incident));
        }
        [$unsolved_changed, $unsolved_not_changed] = $this->getIncidentHandler()->closeUnsolvedIncidents();

        $output->writeln('[incidents]: <info>Changed unsolved incidents: ' . count($unsolved_changed) . '</info>');
        foreach ($unsolved_changed as $incident) {
            $output->writeln($this->printChanged($incident));
        }
        $output->writeln('[incidents]: <comment>Could NOT change unsolved incidents: ' . count($unsolved_not_changed) . '</comment>');
        foreach ($unsolved_not_changed as $incident) {
            $output->writeln($this->printUnchanged($incident));
        }
        $output->writeln('[incidents]:<info> Done.</info>');
    }

    /**
     * @return IncidentHandler
     */
    public function getIncidentHandler(): IncidentHandler
    {
        return $this->incident_handler;
    }

    /**
     * @param Incident $incident
     * @return string
     */
    private function printChanged(Incident $incident): string
    {
        return '[incidents]:<info>Changed incident id: ' . $incident->getId() . ' form state "' . $incident->getStateEdge()->getOldState()->getSlug() . '" to "' . $incident->getStateEdge()->getNewState()->getSlug() . '"</info>';
    }

    /**
     * @param $incident
     * @return string
     */
    private function printUnchanged(Incident $incident): string
    {
        return '[incidents]:<comment> Not Changed incident id: ' . $incident->getId() . ' form state "' . $incident->getState()->getSlug() . '" to "' . $incident->getUnrespondedState()->getSlug() . '"</comment>';
    }

}
