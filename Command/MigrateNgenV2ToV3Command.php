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

class MigrateNgenV2ToV3Command extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:database:migrate')
            ->setDescription('Migrate Ngen V2 To V3.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Closing old incidents...');
        $output->writeln('[incidents]: Internals...');
        $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->all(['origin' => null], [], 50);
//        $admins = $this->getContainer()->get('cert_unlp.ngen.network.admin.handler')->all();
//        $networks = $this->getContainer()->get('cert_unlp.ngen.network.handler')->all();
//        foreach ($networks as $network) {
//            $this->getContainer()->get('doctrine')->getManager()->persist($network);
//        }
//        $this->getContainer()->get('doctrine')->getManager()->flush();
        while ($incidents) {
            foreach ($incidents as $incident) {
                $incident->setOrigin($this->getContainer()->get('cert_unlp.ngen.host.handler')->post(['address' => $incident->getHostAddress()]));
                $this->getContainer()->get('doctrine')->getManager()->persist($incident);
            }
            $this->getContainer()->get('doctrine')->getManager()->flush();
            $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->all(['origin' => null], [], 50);

        }
//        foreach ($admins as $admin) {
//            $contact = new ContactEmail();
//            $contact->setUsername($admin->getEmails()[0]);
//            $contact->setName($admin->getName());
//            $contact->setNetworkAdmin($admin);
//            $contact->setContactType('email');
//            $contact->setContactCase($this->getContainer()->get('doctrine')->getRepository(ContactCase::class)->findOneBySlug('all'));
//            $this->getContainer()->get('doctrine')->getManager()->persist($contact);
//        }
//        if ($output->isVerbose()) {
//            foreach ($closedIncidents as $id => $incident) {
//                $output->writeln('[incidents]: #' . $id . ' hostAdress: ' . $incident['ip'] . ' type: ' . $incident['type'] . ' date: ' . $incident['ip'] . ' lastTimeDetected:' . $incident['lastTimeDetected'] . ' openDays:' . $incident['openDays']);
//            }
//        }
        $output->writeln('[incidents]: Done.');
    }

}
