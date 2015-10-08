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
            array('name' => "Blacklist", 'subject' => "Host %s con servicio SNMP abierto"),
            array('name' => "Botnet", 'subject' => "Host %s formando parte de una botnet"),
            array('name' => "Bruteforce", 'subject' => "Host %s realizando ataques de fuerza bruta"),
            array('name' => "Bruteforcing SSH", 'subject' => "Host %s realizando ataques de fuerza bruta SSH"),
            array('name' => "Copyright", 'subject' => "Problemas de Copyright desde %s"),
            array('name' => "Deface", 'subject' => "Host %s con servicio SNMP abierto"),
            array('name' => "DNS zone transfer", 'subject' => "Host %s enviando SPAM"),
            array('name' => "DOS chargen", 'subject' => "Host %s siendo utilizado para realizar DDOS"),
            array('name' => "DOS NTP", 'subject' => "Host %s siendo utilizado para realizar NTP DDOS"),
            array('name' => "DOS SNMP", 'subject' => "Host %s siendo utilizado para realizar SNMP DDOS"),
            array('name' => "Heartbleed", 'subject' => "Servicios SSL en %s con vulnerabilidad Heartbleed"),
            array('name' => "Malware", 'subject' => "Host %s con servicio SNMP abierto"),
            array('name' => "Open DNS", 'subject' => "Host %s con DNS abierto"),
            array('name' => "Open memcached", 'subject' => "Host %s con DNS abierto"),
            array('name' => "Open NTP monitor", 'subject' => "Host %s con DNS abierto"),
            array('name' => "Open NTP version", 'subject' => "Host %s con DNS abierto"),
            array('name' => "Open SNMP", 'subject' => "Host %s con servicio SNMP abierto"),
            array('name' => "Open MongoDB", 'subject' => "Host %s con servicio MongoDB abierto"),
            array('name' => "Phishing", 'subject' => "Host %s realizando ataques de phishing"),
            array('name' => "Poodle", 'subject' => "Host %s enviando SPAM"),
            array('name' => "Scan", 'subject' => "Host %s realizando scans"),
            array('name' => "Shellshock", 'subject' => "Host %s posiblemente vulnerado mediante ShellShock"),
            array('name' => "Spam", 'subject' => "Host %s enviando SPAM"),
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
