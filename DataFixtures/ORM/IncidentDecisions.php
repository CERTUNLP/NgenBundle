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

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of IncidentFeeds
 *
 * @author dam
 */
class IncidentDecisions extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 2;
    }


    public function load(ObjectManager $manager)
    {
        $array = [
            array('Undefined', 'Undefined', 'Low', 'Low', 'Green', 'Undefined')];
        foreach ($array as $val) {

            $newIncidentType = new IncidentDecision();
            $newIncidentType->setType($this->getReference('incidentType-' . $val[0]));
            $newIncidentType->setFeed($this->getReference('incidentFeed-' . $val[1]));
            $newIncidentType->setImpact($this->getReference('incidentImpact-' . $val[2]));
            $newIncidentType->setUrgency($this->getReference('incidentUrgency-' . $val[3]));
            $newIncidentType->setTlp($val[1]);
            $newIncidentType->setState($this->getReference('IncidentStates-' . $val[5]));

            $manager->persist($newIncidentType);

        }
//        $manager->flush();
    }

}
