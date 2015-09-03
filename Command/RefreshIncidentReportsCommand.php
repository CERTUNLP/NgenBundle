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

class RefreshIncidentReportsCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cert_unlp:incidents:reports:refresh')
                ->setDescription('Walk through markdown files, parse to html, and create reports.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('[incidents:reports]: Starting.');
        $output->write('[incidents:reports]: Getting reports...');

        try {
            $report_files = glob($this->getContainer()->getParameter('cert_unlp.ngen.incident.report.markdown.path') . '/*'); // get all file names
            $common_report_files = glob($this->getContainer()->getParameter('cert_unlp.ngen.incident.report.markdown.path') . '/common/*');
            $output->writeln('Done');
            foreach ($report_files as $file) { // iterate files
                $filename = basename($file);
                if (!in_array($filename, ['TODO.md', 'template.md', 'common'])) {
                    if ($output->isVerbose()) {
                        $output->writeln('[incidents:reports]: parsing ' . $filename);
                    }
                    $html = $this->getContainer()->get('markdown.parser')->transformMarkdown(file_get_contents($file));
                    file_put_contents($this->getContainer()->getParameter('cert_unlp.ngen.incident.report.twig.path') . "/" . str_replace(".md", "Report.html.twig", basename($file)), $html);
                }
            }
            foreach ($common_report_files as $file) { // iterate files
                $filename = basename($file);

                if ($output->isVerbose()) {
                    $output->writeln('[incidents:reports]: parsing ' . $filename);
                }
                $html = $this->getContainer()->get('markdown.parser')->transformMarkdown(file_get_contents($file), false);
                file_put_contents($this->getContainer()->getParameter('cert_unlp.ngen.incident.report.twig.path') . "/BaseReport/" . str_replace(".md", "Report.html.twig", basename($file)), $html);
            }
        } catch (Exception $ex) {
            $output->writeln('[incidents:reports]: Something is wrong.');
        }
        $output->writeln('[incidents:reports]: Done.');
    }

}
