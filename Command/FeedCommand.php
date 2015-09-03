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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FeedCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cert_unlp:feed:shadowserver')
                ->setDescription('Looks to the shadowserver reports site and reports to the incident API.')
                ->addOption('days-ago', '-d', InputOption::VALUE_OPTIONAL, 'Analize reports of x day ago.', '1')
                ->addOption('username', '-u', InputOption::VALUE_OPTIONAL, 'Username to use as reporter.')
                ->addOption('analyze-cache', '-c', InputOption::VALUE_NONE, 'The reports are not downloaded and analyzed only those in cache.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('[shadowserver]: Starting analyzer.');
        $output->writeln('[shadowserver]: Analyzing.');
        $this->getContainer()->get('cert_unlp.ngen.feed.shadowserver')->analyze($input->getOption('days-ago'), $input->getOption('username'), $input->getOption('analyze-cache'));
        $output->writeln('[shadowserver]: Analyzing completed.');
    }

}
