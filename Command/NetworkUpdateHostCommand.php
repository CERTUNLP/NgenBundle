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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NetworkUpdateHostCommand extends ContainerAwareCommand
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
            ->setName('cert_unlp:network:update:host')
            ->setDescription('search networks for hosts that doesn\'t have one.')
            ->addOption('max', '--max', InputOption::VALUE_OPTIONAL, 'limit the update to first $max host', -1);
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
        $offset = 0;
        $max = (int)$input->getOption('max');
        $default_network = $this->getNetworkHandler()->getDefaultNetwork()->getId();
        $hosts = $this->getHostHandler()->all(['network' => $default_network], ['id' => 'desc'], $limit, $offset);
        while ($hosts && $offset !== $max) {
            $output->write('[network update]:<info> Found ' . count($hosts) . ' hosts to update.</info>');
            $output->writeln('<info>Total analyzed ' . $offset . '</info>');
            foreach ($hosts as $host) {
                $output->write('[network update]: Searching: ' . $host);
                $network = $this->getNetworkHandler()->findOneInRange($host->getAddress(), true);
                if ($network && !$network->isDefault()) {
                    $output->write('<info> Found: ' . $network . '</info>');
                    if (!$network->getId()) {
                        $output->write('<info> (NEW) </info>');
                    }
                    if (!$network->getNetworkAdmin()->getId()) {
                        $output->write('<info> (NEW) </info>');
                    }
                    $output->write('<comment> Admin: ' . $network->getNetworkAdmin() . '</comment>');
                    if (!$network->getNetworkEntity()->getId()) {
                        $output->write('<info> (NEW) </info>');
                    }
                    $output->writeln('<comment> Entity: ' . $network->getNetworkEntity() . '</comment>');
                    $host->setNetwork($network);
                    try {
                        $this->getHostHandler()->patch($host);
                    } catch (InvalidFormException $exception) {
                        echo $exception;
                    }
                } else {
                    $output->writeln('<error>...Not Found</error>');
                }
            }
            $offset += $limit;
            $hosts = $this->getHostHandler()->all(['network' => $default_network], ['id' => 'desc'], $limit, $offset);
        }
        if ($offset === $max) {
            $output->writeln('[network update]: Reached Max parameter.');
        }
        $output->writeln('[network update]: Finished.');
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
