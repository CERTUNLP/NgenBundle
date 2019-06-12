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
use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use CertUnlp\NgenBundle\Entity\Network\NetworkExternal;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use CertUnlp\NgenBundle\Services\NetworkRdapClient;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class NetworkHandler extends Handler
{

    private $network_rdap_handler;

    public function __construct(ObjectManager $om, string $entityClass, string $entityType, FormFactoryInterface $formFactory, NetworkRdapClient $network_rdap_handler)
    {
        parent::__construct($om, $entityClass, $entityType, $formFactory);
        $this->network_rdap_handler = $network_rdap_handler;
    }

    /**
     * Get a Entity by id.
     *
     * @param array $parameters
     * @return object
     */
    public function get(array $parameters)
    {
        return $this->repository->findOneBy($parameters);
    }

    public function post(array $parameters, bool $csrf_protection = false, $entity_class_instance = null)
    {
        switch ($parameters['type']) {
            case 'internal':
                $entity_class_instance = new NetworkInternal($parameters['address']);
                break;
            case 'external':
                $entity_class_instance = new NetworkExternal($parameters['address']);
                break;
        }
        unset($parameters['type']);
        return parent::post($parameters, $csrf_protection, $entity_class_instance);
    }

    /**
     * Get a Network.
     *
     * @param string $ip
     * @return Network
     */
    public function getByHostAddress(string $ip): ?Network
    {
        $network = $this->repository->findOneByAddress(['address' => $ip]);

        if (!$network) {
            switch (NetworkElement::guessType($ip)) {
                case FILTER_FLAG_IPV4:
                    return $this->network_rdap_handler->findByIp($ip);
                    break;
                case FILTER_FLAG_IPV6:
                    return $this->network_rdap_handler->findByIp($ip);
                    break;
                default:
                    return null;
            }
        }
        return $network;
    }

    /**
     * Delete a Network.
     *
     * @param Network $network
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
        $networkDB = $this->repository->findOneBy(['address' => $network->getAddress(), 'address_mask' => $network->getAddressMask()]);

        if ($networkDB && $method === 'POST') {
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
