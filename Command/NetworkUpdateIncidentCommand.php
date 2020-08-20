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

use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\HostHandler;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\Network\NetworkHandler;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\IncidentHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NetworkUpdateIncidentCommand extends ContainerAwareCommand
{
    /**
     * @var HostHandler
     */
    private $host_handler;
    /**
     * @var NetworkHandler
     */
    private $network_handler;
    /**
     * @var IncidentHandler
     */
    private $incident_handler;

    public function __construct(IncidentHandler $incident_handler, NetworkHandler $network_handler)
    {
        parent::__construct(null);
        $this->incident_handler = $incident_handler;
        $this->network_handler = $network_handler;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:network:update:incident')
            ->setDescription('Execute a list of enrichments for the incidents');
//            ->addOption('all', '-a', InputOption::VALUE_OPTIONAL, 'execute all enrichments', true)
//            ->addOption('enrichment', '-en', InputOption::VALUE_OPTIONAL, 'execute the enrichment given');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('[network update]: Starting.');
        $limit = 50;
        $offset = 0;
        $incidents = $this->getIncidentHandler()->all(['network' => null], ['id' => 'desc'], $limit, $offset);
        while ($incidents) {
            $output->write('[network update]:<info> Found ' . count($incidents) . ' incidents to update.</info>');
            $output->writeln('<info>Total analyzed ' . $offset . '</info>');
            foreach ($incidents as $incident) {
                $output->write('[network update]: Searching: ' . $incident);
                $network = $incident->getOrigin() ? $incident->getOrigin()->getNetwork() : null;
                if ($network) {
                    $output->write('<info> Found: ' . $network . '</info>');
                    $output->write('<comment> Admin: ' . $network->getNetworkAdmin() . '</comment>');
                    $output->writeln('<comment> Entity: ' . $network->getNetworkEntity() . '</comment>');
                    $incident->setNetwork($network);
                    $this->getIncidentHandler()->patch($incident);
                } else {
                    $output->writeln('<error>...Not Found</error>');
                }
            }
            $offset += $limit;
            $incidents = $this->getIncidentHandler()->all(['network' => null], ['id' => 'desc'], $limit, $offset);
        }
        $output->writeln('[network update]: Finished.');

    }

    /**
     * @return IncidentHandler
     */
    public function getIncidentHandler(): IncidentHandler
    {
        return $this->incident_handler;
    }

    /**
     * @return HostHandler
     */
    public function getHostHandler(): HostHandler
    {
        return $this->host_handler;
    }

    /**
     * @return NetworkHandler
     */
    public function getNetworkHandler(): NetworkHandler
    {
        return $this->network_handler;
    }

}
