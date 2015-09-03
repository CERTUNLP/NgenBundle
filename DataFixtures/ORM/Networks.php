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
use CertUnlp\NgenBundle\Entity\Network;
use ArrayObject;
use CertUnlp\NgenBundle\Entity\AcademicUnit;
use CertUnlp\NgenBundle\Entity\NetworkAdmin;

class Networks extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 2;
    }

    public function load(ObjectManager $manager) {
        $data = array(
            array('ip_mask' => '192.168.0.0/16', 'academic_unit_name' => 'Test', 'admin_name' => 'Support Test', 'admin_email' => 'support@organization.test'));
        $NetworkAdminRepository = $manager->getRepository('CertUnlpNgenBundle:NetworkAdmin');
        $AcademicUnitRepository = $manager->getRepository('CertUnlpNgenBundle:AcademicUnit');
        foreach ($data as $network_data) {
            $Network = new Network();
            $Network->setIp($network_data['ip_mask']);
            $na = $NetworkAdminRepository->findOneByName($network_data['admin_name']);
            $au = $AcademicUnitRepository->findOneByName($network_data['academic_unit_name']);
            if ($na) {
                $Network->setNetworkAdmin($na);
            } else {
                $Network->setNetworkAdmin(new NetworkAdmin($network_data['admin_name'], $network_data['admin_email']));
            }

            if ($au) {
                $Network->setAcademicUnit($au);
            } else {
                $Network->setAcademicUnit(new AcademicUnit($network_data['academic_unit_name']));
            }
            $manager->persist($Network);
            $manager->flush();
            $this->addReference('network-' . $network_data['ip_mask'], $Network);
        }
    }

}
