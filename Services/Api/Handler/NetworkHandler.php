<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Services\Api\Handler\Handler;

class NetworkHandler extends Handler {

    private $default_network;

    public function __construct(ObjectManager $om, $entityClass, $entityType, FormFactoryInterface $formFactory, $default_network) {
        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->default_network = $default_network;
    }

    /**
     * Get a Network.
     *
     * @param mixed $parameters
     *
     * @return NetworkInterface
     */
    public function getByHostAddress($address) {
        $network = $this->repository->findByHostAddress($address);
        if (!$network && $this->default_network) {

            $network = $this->repository->findOneByIp($this->default_network);
        }
        return $network;
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function prepareToDeletion($network, array $parameters = null) {
        $network->setIsActive(FALSE);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function desactivate($network, array $parameters = null) {
        return $this->delete($network, $parameters);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function activate($network, array $parameters = null) {
        $network->setIsActive(TRUE);
        return $this->patch($network, $parameters);
    }

    protected function checkIfExists($network, $method) {
        $networkDB = $this->repository->findOneBy(['ip' => $network->getIP(), 'ipMask' => $network->getIpMask()]);

        if ($networkDB && $method == 'POST') {
            if (!$networkDB->getIsActive()) {
                $networkDB->setIsActive(TRUE);
                $networkDB->setNetworkAdmin($network->getNetworkAdmin());
                $networkDB->setAcademicUnit($network->getAcademicUnit());
            }
            $network = $networkDB;
        }
        return $network;
    }

}
