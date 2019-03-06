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

use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of IncidentFeeds
 *
 * @author dam
 */
class IncidentImpacts extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }


    public function load(ObjectManager $manager)
    {
        $array = [
            array('Low', 'A minimal number of staff are affected and/or able to deliver an acceptable service but this requires extra effort.\nA minimal number of customers are affected and/or inconvenienced but not in a significant way.\nThe financial impact of the Incident is (for example) likely to be less than $1,000.\nThe damage to the reputation of the business is likely to be minimal.'),
            array('Medium', 'A moderate number of staff are affected and/or not able to do their job properly.\nA moderate number of customers are affected and/or inconvenienced in some way.\nThe financial impact of the Incident is (for example) likely to exceed $1,000 but will not be more than $10,000.\nThe damage to the reputation of the business is likely to be moderate.'),
            array('High', 'A large number of staff are affected and/or not able to do their job. A large number of customers are affected and/or acutely disadvantaged in some way. The financial impact of the Incident is (for example) likely to exceed $10,000. The damage to the reputation of the business is likely to be high. Someone has been injured.'),
            array('Undefined', 'Undefined')];

        foreach ($array as $val) {
            $newIncidentType = new IncidentImpact();
            $newIncidentType->setName($val[0]);
            $newIncidentType->setDescription($val[1]);

            $manager->persist($newIncidentType);
            $manager->flush();
            $this->addReference('incidentImpact-' . $val[0], $newIncidentType);


        }
    }

}
