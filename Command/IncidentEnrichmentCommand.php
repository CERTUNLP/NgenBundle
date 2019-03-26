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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IncidentEnrichmentCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:incident:enrichments')
            ->setDescription('Execute a list of enrichments for the incidents')
            ->addOption('all', '-a', InputOption::VALUE_OPTIONAL, 'execute all enrichments', true)
            ->addOption('enrichment', '-en', InputOption::VALUE_OPTIONAL, 'execute the enrichment given');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('cert_unlp:incident:enrichment:teamcymru');

        $arguments = array();

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);
    }

}
