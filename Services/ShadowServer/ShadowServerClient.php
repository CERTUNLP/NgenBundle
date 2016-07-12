<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\ShadowServer;

use Goutte\Client as Scraper;
use Ddeboer\DataImport\Reader\CsvReader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use CertUnlp\NgenBundle\Services\ShadowServer\ShadowServerCsvRow;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\ArrayReader;
use Ddeboer\DataImport\Writer\CsvWriter;

/**
 * Description of ShadowServerClient
 *
 * @author demyen
 */
class ShadowServerClient implements ContainerAwareInterface {

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    public function __construct($reports_url, $shadow_server_user, $shadow_server_password, $download_directory, $shadow_server_report_type_factory, ContainerInterface $container) {

        $this->download_directory = $download_directory . "/shadowserver/reports/";

        if (!is_dir($this->download_directory)) {

            if (!mkdir($this->download_directory, 0777, true)) {
                die('Failed to create folders...');
            }
        }
        $this->reports_url = $reports_url;
        $this->scraper = new Scraper();
        $this->scraper->getClient()->setDefaultOption('config/curl/' . CURLOPT_TIMEOUT, 0);
        $this->scraper->getClient()->setDefaultOption('config/curl/' . CURLOPT_TIMEOUT_MS, 0);
        $this->scraper->getClient()->setDefaultOption('config/curl/' . CURLOPT_CONNECTTIMEOUT, 0);
        $this->scraper->getClient()->setDefaultOption('config/curl/' . CURLOPT_RETURNTRANSFER, true);
        $this->shadow_server_user = $shadow_server_user;
        $this->shadow_server_password = $shadow_server_password;
        $this->shadow_server_report_type_factory = $shadow_server_report_type_factory;
        $this->setContainer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function shadowServerReportSiteLogin() {
        $crawler = $this->scraper->request('GET', $this->reports_url);
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->scraper->submit($form, array('user' => $this->shadow_server_user, 'password' => $this->shadow_server_password));

        return $crawler;
    }

    public function getReportsLinks($daysAgo) {

        try {
            $crawler = $this->shadowServerReportSiteLogin();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $date = new \DateTime();
        $report_links = [];
        $crawler->filter('ul#treemenu1')->children()->each(function ($node) use($date, &$report_links, $daysAgo) {
            if (strpos($node->text(), $date->format('Y')) === 0) {
                $node->children()->children()->each(function($li) use ($date, &$report_links, $daysAgo) {
                    if (strpos($li->text(), $date->format('F')) === 0) {

                        $day = ($date->format('d') == '01') ? $date->format('d') : $date->modify('-' . $daysAgo . ' day')->format('d');
                        $li->children()->children()->each(function($li2) use($day, &$report_links) {
                            if (strpos($li2->text(), $day) === 0) {
                                $li2->children()->children()->each(function($li3) use (&$report_links) {
                                    $a = $li3->filter('a');
                                    $report_links[] = ['name' => $a->text(), 'link' => $a->attr('href')];
                                });
                            }
                        });
                    }
                });
            }
        });

        return $report_links;
    }

    private function cleanDownloadDirectory() {
        $files = glob($this->download_directory . '*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file}
            }
        }
    }

    public function downloadReports($daysAgo) {
        $files = $this->getReportsLinks($daysAgo);
        $this->cleanDownloadDirectory();
        foreach ($files as $file) {
            $content = file_get_contents($file['link']);
            file_put_contents($this->download_directory . $file['name'], $content);
        }
    }

    public function importCsv($daysAgo, $analyzeCache) {
        if (!$analyzeCache) {
            $this->downloadReports($daysAgo);
        }
        $files = glob($this->download_directory . '*'); // get all file names
        $shadow_server_csv_rows = array();
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                $csv_file = new \SplFileObject($file);
                $reader = new CsvReader($csv_file);
                $reader->setHeaderRowNumber(0);
                foreach ($reader as $row) {
                    $header = array_keys($row);
                    $array_reader = new ArrayReader(array($row));
                    $workflow = new Workflow($array_reader);
                    $writer = new CsvWriter();
                    $shadow_server_report_evidence = '/tmp/' . uniqid('shadow_server_report_evidence') . ".csv";
                    touch($shadow_server_report_evidence);
                    chmod($shadow_server_report_evidence, 0777);
                    $writer->setStream(fopen($shadow_server_report_evidence, 'w'));
                    $writer->writeItem($header);
                    $workflow->addWriter($writer);
                    $workflow->process();
                    $reportType = $this->shadow_server_report_type_factory->getReportTypeFromCsvRow($row, $file, $shadow_server_report_evidence);
                    if ($reportType) {
                        $shadow_server_csv_rows[] = $reportType;
                    }
                }
            }
        }

        return $shadow_server_csv_rows;
    }

}
