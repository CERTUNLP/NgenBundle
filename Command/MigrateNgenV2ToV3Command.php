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

class MigrateNgenV2ToV3Command extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('cert_unlp:database:migrate')
            ->setDescription('Migrate Ngen V2 To V3.')
            ->addOption('offset', '-o', InputOption::VALUE_OPTIONAL, 'Es un offest por si queremos correr varios a la vez, tener en cuenta que corre de a 50 elementos',0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[incidents]: Starting.');
        $output->writeln('[incidents]: Closing old incidents...');
        $output->writeln('[incidents]: Internals...');
        $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->all(['origin' => null], [], 50, $input->getOption('offset'));
        while ($incidents) {
            foreach ($incidents as $incident) {
                echo($incident->getId()."\n");
                echo($incident->getHostAddress())." era la ip esto\n";

                $incident->setOrigin($this->getContainer()->get('cert_unlp.ngen.host.handler')->post(['address' => $incident->getHostAddress()]));

                $this->getContainer()->get('doctrine')->getManager()->persist($incident);
            }
            $this->getContainer()->get('doctrine')->getManager()->flush();
            $incidents = $this->getContainer()->get('cert_unlp.ngen.incident.internal.handler')->all(['origin' => null], [], 50,$input->getOption('offset'));

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
