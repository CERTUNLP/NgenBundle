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
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\IncidentHandler;
use Closure;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
        $output->writeln('[incidents]: <question>Changing unresponded incidents...</question>');

        $this->paginateQuery($this->getIncidentHandler()->getRepository()->queryAllUnresponded()->setFirstResult(0)->setMaxResults(100), $output, function (Incident $incident): ?IncidentState {
            return $incident->getUnrespondedState();
        });
        $output->writeln('[incidents]: <question>Changing unsolved incidents...</question>');

        $this->paginateQuery($this->getIncidentHandler()->getRepository()->queryAllUnsolved()->setFirstResult(0)->setMaxResults(100), $output, function (Incident $incident): ?IncidentState {
            return $incident->getUnsolvedState();
        });

        $output->writeln('[incidents]:<info> Done.</info>');
    }

    /**
     * @param QueryBuilder $query
     * @param OutputInterface $output
     * @param Closure $clousure
     * @return Paginator
     */
    private function paginateQuery(QueryBuilder $query, OutputInterface $output, Closure $clousure): Paginator
    {
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        foreach ($paginator as $incident) {
            if ($incident->setState($clousure($incident))) {
                $this->getIncidentHandler()->getEntityManager()->persist($incident);
                $output->writeln($this->printChanged($incident));
            } else {
                $output->writeln($this->printUnchanged($incident));
            }
        }
        $this->getIncidentHandler()->getEntityManager()->flush();
        return $paginator;
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
