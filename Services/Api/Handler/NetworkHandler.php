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

use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class NetworkHandler extends Handler
{

    private $default_network;

    public function __construct(ObjectManager $om, string $entityClass, string $entityType, FormFactoryInterface $formFactory, $default_network)
    {
        parent::__construct($om, Network::class, $entityType, $formFactory);
        $this->default_network = $default_network;
    }

    /**
     * Get a Entity by id.
     *
     * @param array $parameters
     * @return object
     */
    public function get(array $parameters)
    {
        $ip_and_mask = explode('/', $parameters['ip']);

        $parameters['ip'] = $ip_and_mask[0];
        if (isset($ip_and_mask[1])) {
            $parameters['ipMask'] = $ip_and_mask[1];
        }
        return $this->repository->findOneBy($parameters);
    }

    /**
     * Get a Network.
     *
     * @param $address
     * @return NetworkInterface
     */
    public function getByHostAddress(string $address): NetworkInterface
    {
        return $this->repository->findByIpV4($address);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($network, array $parameters = null)
    {
        $network->setIsActive(FALSE);
    }

    protected function checkIfExists($network, $method)
    {
        $networkDB = $this->repository->findOneBy(['ip' => $network->getIP(), 'ipMask' => $network->getIpMask()]);

        if ($networkDB && $method == 'POST') {
            if (!$networkDB->getIsActive()) {
                $networkDB->setIsActive(TRUE);
                $networkDB->setNetworkAdmin($network->getNetworkAdmin());
                $networkDB->setNetworkEntity($network->getNetworkEntity());
            }
            $network = $networkDB;
        }
        return $network;
    }

}
