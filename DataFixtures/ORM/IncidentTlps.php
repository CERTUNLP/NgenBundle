<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\DataFixtures\ORM;

use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of IncidentClosingTypes
 *
 * @author dam
 */
class IncidentTlps extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $incident_closing_types = array(
            array('red', '#ff0033', 'Sources may use TLP:RED when information cannot be effectively acted upon by additional parties, and could lead to impacts on a party\'s privacy, reputation, or operations if misused.', 1, 'Recipients may not share TLP:RED information with any parties outside of the specific exchange, meeting, or conversation in which it was originally disclosed. In the context of a meeting, for example, TLP:RED information is limited to those present at the meeting. In most circumstances, TLP:RED should be exchanged verbally or in person.', 'TLP:RED', 'Not for disclosure, restricted to participants only.')
        , array('amber', '#ffc000', 'Sources may use TLP:AMBER when information requires support to be effectively acted upon, yet carries risks to privacy, reputation, or operations if shared outside of the organizations involved. ', 0, 'Recipients may only share TLP:AMBER information with members of their own organization, and with clients or customers who need to know the information to protect themselves or prevent further harm. Sources are at liberty to specify additional intended limits of the sharing: these must be adhered to.\n', 'TLP:AMBER', 'Limited disclosure, restricted to participants organizations.')
        , array('green', '#33ff00', 'Sources may use TLP:GREEN when information is useful for the awareness of all participating organizations as well as with peers within the broader community or sector.', 0, 'Recipients may share TLP:GREEN information with peers and partner organizations within their sector or community, but not via publicly accessible channels. Information in this category can be circulated widely within a particular community. TLP:GREEN information may not be released outside of the community.\n', 'TLP:GREEN', 'Limited disclosure, restricted to the community.')
        , array('white', '#FFFFFF', 'Sources may use TLP:WHITE when information carries minimal or no foreseeable risk of misuse, in accordance with applicable rules and procedures for public release.', 0, 'Subject to standard copyright rules, TLP:WHITE information may be distributed without restriction.\n', 'TLP:WHITE', 'Disclosure is not limited.')
        );

        foreach ($incident_closing_types as $val) {
            $newIncidentTlp = new IncidentTlp();
            $newIncidentTlp->setName($val[0]);
            $newIncidentTlp->setRgb($val[1]);
            $newIncidentTlp->setWhen($val[2]);
            $newIncidentTlp->setEncrypt(0);
            $newIncidentTlp->setWhy($val[4]);
            $newIncidentTlp->setInformation($val[5]);
            $newIncidentTlp->setDescription($val[6]);

            $manager->persist($newIncidentTlp);

        }

//        $manager->flush();
    }

}
