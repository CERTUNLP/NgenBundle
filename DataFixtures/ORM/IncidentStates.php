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

use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of IncidentClosingTypes
 *
 * @author dam
 */
class IncidentStates extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $incident_closing_types = array(
            array('name' => "Open"),
            array('name' => "Staging"),
            array('name' => "Closed"),
            array('name' => "Closed by inactivity"),
            array('name' => "Stand by"),
            array('name' => "Removed"),
            array('name' => "Unresolved"),
        );
        foreach ($incident_closing_types as $incident_closing_type) {
            $newIncidentType = new IncidentState();
            $newIncidentType->setName($incident_closing_type['name']);

            $manager->persist($newIncidentType);

            $this->addReference('IncidentStates-' . $incident_closing_type['name'], $newIncidentType);
        }

        $manager->flush();
    }

}
