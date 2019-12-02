<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use CertUnlp\NgenBundle\Entity\User;
use Doctrine\ORM\EntityManager;


class IncidentFactory
{

    private $entityManager;
    private $team;

    public function __construct(EntityManager $entityManager, $securityTeam, array $team)
    {
        $this->entityManager = $entityManager;
        $this->team = $team;
    }

    public function getIncident()
    {  $repository = $this->entityManager->getRepository(IncidentTlp::class);
        $newTLP = $repository->findOneBySlug('white');
        $incident = new Incident();
        $host= new Host();
        $net= new NetworkInternal();
        $host->setAddress("example.com");
        $host->setNetwork($net);
        $admin= (new User())->setFirstName("Juan");
        $netAdmin=(new NetworkAdmin())->setName("Roberto");
        $netAdmin->addContact((new ContactEmail())->setUserName("pepe@pepe.com"));
        $net->setNetworkAdmin($netAdmin);
        $incident->setTlp($newTLP);
        $incident->setNetwork($net);
        $incident->setAssigned($admin);
        $incident->setAddress("10.0.0.1");

        return $incident;
    }

    /**
     * @return array
     */
    public function getTeam(): array
    {
        return $this->team;
    }
}
