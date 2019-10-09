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
use Symfony\Component\Console\Input\InputOption;


class GetReferenceTaxonomyFromEnisaCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:taxonomy:update')
            ->setDescription('Upgrade Referencial Taxonomy from WorkingGroup.')
            ->addOption('url', '-u', InputOption::VALUE_OPTIONAL, 'Es la url para obtener el json RAW','https://raw.githubusercontent.com/enisaeu/Reference-Security-Incident-Taxonomy-Task-Force/master/working_copy/machinev1');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[Updating Taxonomy Reference]: Starting.');
        $output->writeln('[Updating Taxonomy Reference]: Getting from '.$input->getOption('url'));
        $json = file_get_contents($input->getOption('url'));
        $obj = json_decode($json);
        echo($obj->version);
        print_r($obj->predicates);
        print_r($obj->values);
        $output->writeln('[incidents]: Done.');
    }

}
