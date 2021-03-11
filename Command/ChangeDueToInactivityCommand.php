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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeDueToInactivityCommand extends ContainerAwareCommand
{
    /**
     * @var IncidentHandler
     */
    private $incident_handler;
    /**
     * @var string
     */
    private string $lang;

    public function __construct(IncidentHandler $incident_handler, string $ngen_lang)
    {
        parent::__construct(null);
        $this->incident_handler = $incident_handler;
        $this->lang = $ngen_lang;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:incidents:change-due-to-inactivity')
            ->setDescription('Walk through incidents to make an automatic close.')
            ->addOption('max', '--max', InputOption::VALUE_OPTIONAL, 'limit the update to first $max', -1);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: <info>Starting.</info>');
        $limit = 50;
        $offset = 0;
        $max = (int)$input->getOption('max');
        $paginated_unresponded = true;
        $paginated_unsolved = true;

        while ($paginated_unresponded && $offset !== $max) {
            $output->writeln('[incidents]: <question>Changing unresponded incidents...</question>');

            $paginated_unresponded = count($this->paginateQuery($this->getIncidentHandler()->getRepository()->queryAllUnresponded()->setFirstResult($offset)->setMaxResults($limit), $output, function (Incident $incident): ?IncidentState {
                return $incident->getUnrespondedState();
            }));
            $offset += $limit;
        }

        $offset = 0;
        while ($paginated_unsolved && $offset !== $max) {
            $output->writeln('[incidents]: <question>Changing unsolved incidents...</question>');

            $paginated_unsolved = count($this->paginateQuery($this->getIncidentHandler()->getRepository()->queryAllUnsolved()->setFirstResult($offset)->setMaxResults($limit), $output, function (Incident $incident): ?IncidentState {
                return $incident->getUnsolvedState();
            }));
            $offset += $limit;
        }

        if ($offset === $max) {
            $output->writeln('[incidents]: Reached Max parameter.');
        }
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
            if ($incident->setState($clousure($incident), $this->getLang())) {
                $this->getIncidentHandler()->patch($incident);
                $output->writeln($this->printChanged($incident));
            } else {
                $output->writeln($this->printUnchanged($incident));
            }
        }
        return $paginator;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
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
