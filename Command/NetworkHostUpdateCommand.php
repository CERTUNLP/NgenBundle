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

use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\HostHandler;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\Network\NetworkHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NetworkHostUpdateCommand extends ContainerAwareCommand
{
    /**
     * @var HostHandler
     */
    private $host_handler;
    /**
     * @var NetworkHandler
     */
    private $network_handler;

    public function __construct(HostHandler $host_handler, NetworkHandler $network_handler)
    {
        parent::__construct(null);
        $this->host_handler = $host_handler;
        $this->network_handler = $network_handler;
    }

    public function configure()
    {
        $this
            ->setName('cert_unlp:network:host:update')
            ->setDescription('Host update for new networks topology');
//            ->addOption('all', '-a', InputOption::VALUE_OPTIONAL, 'execute all enrichments', true)
//            ->addOption('enrichment', '-en', InputOption::VALUE_OPTIONAL, 'execute the enrichment given');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[network update]: Starting.');
        $limit = 50;
        $offset = 17500;
        $networks = $this->getNetworkHandler()->all([], ['id' => 'desc'], $limit, $offset);
        while ($networks) {
            $output->write('[network update]:<info> Found ' . count($networks) . ' hosts to update.</info>');
            $output->writeln('<info>Total analyzed ' . $offset . '</info>');
            foreach ($networks as $network) {
                $output->write('[network update]: Searching new hosts for: ' . $network->getAddressAndMask());
                $hosts = $this->getHostHandler()->getRepository()->findInRange($network->getAddressAndMask(), true);
                $output->writeln('<info> Found ' . count($hosts) . ' hosts to update.</info>');

                foreach ($hosts as $host) {
                    $output->write('<comment>[network update]: Updating: ' . $host . ' from:' . $host->getNetwork()->getAddressAndMask() . ' to: ' . $network->getAddressAndMask() . '</comment>');
                    $host->setNetwork($network);
                    try {
                        $this->getHostHandler()->patch($host);
                        $output->writeln('<info>...Done</info>');
                    } catch (InvalidFormException $exception) {
                        $output->writeln('<error>...Error</error>');
                    }
                }
                $offset += $limit;
                $networks = $this->getNetworkHandler()->all([], ['id' => 'desc'], $limit, $offset);
            }
            $output->writeln('[network update]: Finished.');
        }
    }

    /**
     * @return NetworkHandler
     */
    public function getNetworkHandler(): NetworkHandler
    {
        return $this->network_handler;
    }

    /**
     * @return HostHandler
     */
    public function getHostHandler(): HostHandler
    {
        return $this->host_handler;
    }

}
