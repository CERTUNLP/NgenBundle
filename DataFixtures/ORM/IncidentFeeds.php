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
use CertUnlp\NgenBundle\Entity\IncidentFeed;

/**
 * Description of IncidentFeeds
 *
 * @author dam
 */
class IncidentFeeds extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 1;
    }

    public function load(ObjectManager $manager) {
        $incident_feed_types = array(
            array('name' => "Bro"),
            array('name' => "Constituency"),
            array('name' => "Shadowserver"),
            array('name' => "Netflow"),
            array('name' => "External report"),
        );
        foreach ($incident_feed_types as $incident_feed_type) {
            $newIncidentType = new IncidentFeed();
            $newIncidentType->setName($incident_feed_type['name']);

            $manager->persist($newIncidentType);
            $manager->flush();

            $this->addReference('incidentFeed-' . $incident_feed_type['name'], $newIncidentType);
        }
    }

}
