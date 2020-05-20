<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\EntityApi;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use CertUnlp\NgenBundle\Entity\Network\NetworkExternal;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use CertUnlp\NgenBundle\Form\NetworkType;
use CertUnlp\NgenBundle\Repository\NetworkRepository;
use CertUnlp\NgenBundle\Service\NetworkRdapClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Form\FormFactoryInterface;

class NetworkHandler extends Handler
{
    /**
     * @var NetworkRdapClient
     */
    private $network_rdap_handler;

    /**
     * NetworkHandler constructor.
     * @param EntityManagerInterface $entity_manager
     * @param NetworkRepository $repository
     * @param NetworkType $entity_ype
     * @param FormFactoryInterface $form_factory
     * @param NetworkRdapClient $network_rdap_handler
     */
    public function __construct(EntityManagerInterface $entity_manager, NetworkRepository $repository, NetworkType $entity_ype, FormFactoryInterface $form_factory, NetworkRdapClient $network_rdap_handler)
    {
        parent::__construct($entity_manager, $repository, $entity_ype, $form_factory);
        $this->network_rdap_handler = $network_rdap_handler;
    }

    /**
     * {@inheritDoc}
     */
    public function cleanParameters(array $parameters): array
    {
        unset($parameters['type']);
        return $parameters;
    }

    /**
     * @param string $ip
     * @return Network|null
     */
    public function getByHostAddress(string $ip): ?Network
    {
        $network = $this->getRepository()->findOneInRange($ip);

        if (!$network) {
            switch (NetworkElement::guessType($ip)) {
                case FILTER_FLAG_IPV6:
                case FILTER_FLAG_IPV4:
                    return $this->getNetworkRdapHandler()->findByIp($ip);
                    break;
                default:
                    return null;
            }
        }
        return $network;
    }

    /**
     * @return NetworkRdapClient
     */
    public function getNetworkRdapHandler(): NetworkRdapClient
    {
        return $this->network_rdap_handler;
    }


    /**
     * @param EntityApi|Network $entity_db
     * @param EntityApi|Network $entity
     * @return EntityApi|Network
     */
    public function mergeEntity(EntityApi $entity_db, EntityApi $entity): EntityApi
    {
        return $entity_db->setNetworkAdmin($entity->getNetworkAdmin())->setNetworkEntity($entity->getNetworkEntity());
    }

    /**
     * @param array $parameters
     * @return EntityApi|Network
     * @throws ClassNotFoundException
     */
    public function createEntityInstance(array $parameters = []): EntityApi
    {
        switch ($parameters['type']) {
            case 'internal':
                $entity = new NetworkInternal($parameters['address']);
                break;
            case 'external':
                $entity = new NetworkExternal($parameters['address']);
                break;
            default:
                throw new ClassNotFoundException('Network class: "' . $parameters['type'] . '" does not exist.', null);
        }
        return $entity;
    }

}
