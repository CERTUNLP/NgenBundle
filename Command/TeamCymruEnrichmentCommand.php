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

use DOMDocument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TeamCymruEnrichmentCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:incident:enrichment:teamcymru')
            ->setDescription('Adds ASN and CC enrichments to the incidents');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[teamCymru]: Starting.');
        $output->writeln('[teamCymru]: Getting networks for enrichment');
        $networks = $this->getContainer()->get('cert_unlp.ngen.network.handler')->all(['asn' => null], [], 50);
        $errors = 0;
        while ($networks) {
            $output->writeln('[teamCymru]: Analysing ' . count($networks) . ' networks.');
            foreach ($networks as $network) {
                $ans_and_cc = $this->getAsnAndCC($network->getAddress());
                if ($ans_and_cc) {
                    $network->setAsn($ans_and_cc['asn']);
                    $network->setCountryCode($ans_and_cc['cc']);
                    $this->getContainer()->get('doctrine')->getManager()->persist($network);
                    if ($output->getVerbosity()) {
                        $output->writeln('[teamCymru]: #' . $network->getId() . ' ASN: ' . $ans_and_cc['asn'] . ' CC: ' . $ans_and_cc['cc']);
                    }
                } else {
                    $errors++;
                    if ($errors === 3) {
                        $output->writeln('<error>[teamCymru]: Too many disconections! Aborting!</error>');
                        return;
                    }
                }
            }

            $output->writeln('[teamCymru]: Networks analysed.');
            $this->getContainer()->get('doctrine')->getManager()->flush();
            $networks = $this->getContainer()->get('cert_unlp.ngen.network.handler')->all(['asn' => null], [], 50);
        }
        $output->writeln('[teamCymru]: Done.');
    }

    private function getAsnAndCC(string $ip): array
    {
        $postfields = array('action' => 'do_whois', 'family' => 'ipv6', 'method_whois' => 'whois', 'bulk_paste' => $ip, 'flag_cc' => 'cc', 'submit_paste' => 'Submit');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://asn.cymru.com/cgi-bin/whois.cgi');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $result = curl_exec($ch);
        if ($result) {
            $doc = new DOMDocument(null, 'UTF-8');
            @$doc->loadHTML($result);
            $node = $doc->getElementsByTagName('pre');
            $response = explode('|', str_replace(['AS Name', "\r\n", "\r", "\n", ' '], ['AS Name |', '', '', '', ''], $node->item(0)->nodeValue));
            return ['asn' => $response[4], 'cc' => $response[6]];
        }
        return [];
    }
}
