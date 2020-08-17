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

class NetworkUpdateCommand extends ContainerAwareCommand
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
            ->setName('cert_unlp:network:update')
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
//        $rdap_client = new Rdap();

        $output->writeln('[network update]: Starting.');
        $limit = 50;
        $offset = 0;
        $hosts = $this->getHostHandler()->all(['network' => null, 'ip' => '96.8.28.31'], ['ip'=>'desc'], $limit, $offset);
        while ($hosts) {
            $output->writeln('[network update]: Found ' . count($hosts) . ' hosts to update.');
            foreach ($hosts as $host) {
                $output->write('[network update]: Searching: ' . $host);
                $network = $this->getNetworkHandler()->findOneInRange($host->getAddress(), true);
                if ($network) {
                    $output->write('<info> Found: ' . $network . '</info>');
                    $output->write('<comment> Admin: ' . $network->getNetworkAdmin() . '</comment>');
                    $output->writeln('<comment> Entity: ' . $network->getNetworkEntity() . '</comment>');
                    $host->setNetwork($network);
                    try {
                    $this->getHostHandler()->patch($host);

                    }catch (InvalidFormException $exception){
                        echo $exception;
                    }
                } else {
                    $output->writeln('<error>...Not Found</error>');
                }
            }
            $offset += $limit;
            $hosts = $this->getHostHandler()->all(['network' => null, 'domain' => null], ['ip'=>'desc'], $limit, $offset);
        }
        $output->writeln('[network update]: Finished.');

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
