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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CertUnlp\NgenBundle\Entity\IncidentType;
use Doctrine\Common\Collections\ArrayCollection;

class IncidentTypes extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 0;
    }

    public function load(ObjectManager $manager) {
        $incident_types = array(
            array('name' => "Blacklist"),
            array('name' => "Botnet"),
            array('name' => "Bruteforce"),
//            array('name' => "Bruteforcing SSH"),
            array('name' => "Copyright"),
            array('name' => "Deface"),
            array('name' => "DNS zone transfer"),
            array('name' => "DOS chargen"),
            array('name' => "DOS NTP"),
            array('name' => "DOS SNMP"),
            array('name' => "Heartbleed"),
            array('name' => "Malware"),
            array('name' => "Open Chargen"),
            array('name' => "Open Elasticsearch"),
            array('name' => "Open IPMI"),
            array('name' => "Open ISAKMP"),
            array('name' => "Open MSSQL"),
            array('name' => "Open NetBios"),
            array('name' => "Open QOTD"),
            array('name' => "Open RDP"),
            array('name' => "Open Redis"),
            array('name' => "Open SMB"),
            array('name' => "Open MDNS"),
            array('name' => "Open SSDP"),
            array('name' => "Open Telnet"),
            array('name' => "Open TFTP"),
            array('name' => "Open VNC"),
            array('name' => "Open DNS"),
            array('name' => "Open memcached"),
            array('name' => "Open NTP monitor"),
            array('name' => "Open NTP version"),
            array('name' => "Open SNMP"),
            array('name' => "Open LDAP"),
            array('name' => "Open MongoDB"),
            array('name' => "Phishing Mail"),
            array('name' => "Phishing Web"),
            array('name' => "Open Portmap"),
            array('name' => "Poodle"),
            array('name' => "RPZ Botnet"),
            array('name' => "RPZ DBL"),
            array('name' => "RPZ Drop"),
            array('name' => "RPZ Malware"),
            array('name' => "RPZ Malware Aggressive"),
            array('name' => "Scan"),
            array('name' => "Shellshock"),
            array('name' => "Spam"),
            array('name' => "SQL Injection"),
            array('name' => "SSL Poodle"),
            array('name' => "Suspicious Behavior"),
        );

        foreach ($incident_types as $incident_type) {
            $newIncidentType = new IncidentType();
            $newIncidentType->setName($incident_type['name']);

            $manager->persist($newIncidentType);

            $this->addReference('incidentType-' . $incident_type['name'], $newIncidentType);
        }

        $manager->flush();
    }

}
