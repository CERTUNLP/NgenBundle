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

use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of IncidentFeeds
 *
 * @author dam
 */
class IncidentUrgencies extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }


    public function load(ObjectManager $manager)
    {
        $array = [array('High', 'The damage caused by the Incident increases rapidly.\nWork that cannot be completed by staff is highly time sensitive.\nA minor Incident can be prevented from becoming a major Incident by acting immediately.\nSeveral users with VIP status are affected.'),
            array('Low', 'The damage caused by the Incident only marginally increases over time.\nWork that cannot be completed by staff is not time sensitive.')
            , array('Medium', 'The damage caused by the Incident increases considerably over time.\nA single user with VIP status is affected')
            , array('Undefined', 'Undefined')];

        foreach ($array as $val) {
            $newIncidentType = new IncidentUrgency();
            $newIncidentType->setName($val[0]);
            $newIncidentType->setDescription($val[1]);

            $manager->persist($newIncidentType);
            $manager->flush();
            $this->addReference('incidentUrgency-' . $val[0], $newIncidentType);

        }
    }

}
