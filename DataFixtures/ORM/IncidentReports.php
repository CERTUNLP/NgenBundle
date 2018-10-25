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

use CertUnlp\NgenBundle\Entity\IncidentReport;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class IncidentReports extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }


    public function load(ObjectManager $manager)
    {
        include 'incident_report_array.php';

        $incidentTypeRepository = $manager->getRepository('CertUnlpNgenBundle:IncidentType');
        foreach ($incident_reports as $incident_report) {
            $newIncidentReport = new IncidentReport();
            foreach ($incident_report as $key => $value) {
                if ($key == 'type') {
                    $newIncidentReport->setType($incidentTypeRepository->findOneBySlug($value));
                } else {
                    if ($key != 'updated_at' && $key != 'created_at') {
                        $method = 'set' . preg_replace_callback('/[-_](.)/', function ($matches) {
                                return strtoupper($matches[1]);
                            }, $key);;
                        $newIncidentReport->$method($incident_report[$key]);
                    }
                }

            }

            $manager->persist($newIncidentReport);
            $manager->flush();
        }

    }

}
