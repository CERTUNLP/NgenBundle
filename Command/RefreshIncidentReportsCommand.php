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

    protected function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if (is_array($tags) AND count($tags) > 0) {
            if ($invert == FALSE) {
                return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            } else {
                return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
            }
        } elseif ($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    protected function configure() {
        $this
                ->setName('cert_unlp:incidents:reports:refresh')
                ->setDescription('Walk through markdown files, parse to html, and create reports.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('[incidents:reports]: Starting.');
        $output->writeln('[incidents:reports]: Getting reports...');
        try {
            $output->writeln('[incidents:reports]: Parsing internal incident reports.');
            $this->parse_markdowns($this->getContainer()->getParameter('kernel.root_dir')."/../vendor/certunlp/ngen-bundle/Resources/views/InternalIncident/Report/Twig", $this->getContainer()->getParameter('cert_unlp.ngen.incident.internal.report.twig.path'), $output, "es");
            $output->writeln('[incidents:reports]: Done.');
            $output->writeln('[incidents:reports]: Parsing internal external reports.');
            $this->parse_markdowns($this->getContainer()->getParameter('kernel.root_dir')."/../vendor/certunlp/ngen-bundle/Resources/views/ExternalIncident/Report/Twig", $this->getContainer()->getParameter('cert_unlp.ngen.incident.external.report.twig.path'), $output, "en");
            $output->writeln('[incidents:reports]: Done.');
        } catch (Exception $ex) {
            $output->writeln('[incidents:reports]: Something is wrong.');
        }
        $output->writeln('[incidents:reports]: Done.');
    }

    private function parse_markdowns($markdown_files_path, $twig_files_path, $output, $lang = true) {
        $report_files = glob($markdown_files_path . '/*'); // get all file names
        $common_report_files = glob($markdown_files_path . '/common/*');

//        die;

        foreach ($report_files as $file) { // iterate files
            $filename = basename($file);
            if (!in_array($filename, ['TODO.md', 'template.md', 'common', 'BaseReport', 'reportReply.html.twig', 'baseReport.html.twig'])) {
                if ($output->isVerbose()) {
                    $output->writeln('[incidents:reports]: parsing ' . $filename);
                }
                $html = $this->getContainer()->get('markdown.parser')->transformMarkdown(file_get_contents($file));

//                var_dump(str_split($filename, strpos($filename, 'Report.html.twig'))[0]);
//                die;
                $templateContent = $this->getContainer()->get('twig')->loadTemplate('CertUnlpNgenBundle:InternalIncident:Report/Twig/' . $filename);
                $incident = new \stdClass();
                $incident->hostAddress = "{{incident.hostAddress}}";
                $params['problem'] = trim($templateContent->renderBlock('problem', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'), array('incident' => array(new \stdClass(), 'incident'))));
                if ($templateContent->hasBlock('derivated_problem_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'))) {
      
                    $params['derivated_problem'] = trim($this->strip_tags_content($templateContent->renderBlock('derivated_problem_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'), array('incident' => array(new \stdClass(), 'incident')))));
                }
                if ($templateContent->hasBlock('verification_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'))) {
                    $params['verification'] = trim($this->strip_tags_content($templateContent->renderBlock('verification_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'), array('incident' => array(new \stdClass(), 'incident')))));
                }
                if ($templateContent->hasBlock('recomendations_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'))) {
                    $params['recomendations'] = trim($this->strip_tags_content($templateContent->renderBlock('recomendations_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'), array('incident' => array(new \stdClass(), 'incident')))));
                }
                if ($templateContent->hasBlock('more_information_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'))) {
                    $params['more_information'] = trim($this->strip_tags_content($templateContent->renderBlock('more_information_content', array('incident' => $incident, "father" => 'CertUnlpNgenBundle:InternalIncident:Report/Twig/BaseReport/baseReport.html.twig'), array('incident' => array(new \stdClass(), 'incident')))));
                }
                $params['lang'] = $lang;
                $params['type'] = str_split($filename, strpos($filename, 'Report.html.twig'))[0];
                try {
                    $this->getContainer()->get('cert_unlp.ngen.incident.type.report.handler')->post($params);
                } catch (Exception $exc) {
//                    continue;
                }
            }
        }
//        foreach ($common_report_files as $file) { // iterate files
//            $filename = basename($file);
//
//            if ($output->isVerbose()) {
//                $output->writeln('[incidents:reports]: parsing ' . $filename);
//            }
//            $html = $this->getContainer()->get('markdown.parser')->transformMarkdown(file_get_contents($file));
//            $this->getContainer()->get('cert_unlp.ngen.incident.type.report.handler');
//        }
    }

}
