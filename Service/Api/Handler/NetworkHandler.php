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

use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use CertUnlp\NgenBundle\Entity\Network\NetworkExternal;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use CertUnlp\NgenBundle\Form\NetworkType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
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
     * @param string $address
     * @param bool $rdap_lookup
     * @return Network|null
     */
    public function findOneInRange(string $address, bool $rdap_lookup = false): ?Network
    {
        $network = $this->getRepository()->findOneInRange($address);

        if (!$network && $rdap_lookup) {
            switch (NetworkElement::guessType($address)) {
                case FILTER_FLAG_IPV6:
                case FILTER_FLAG_IPV4:
                    return $this->getNetworkRdapHandler()->findByIp($address);
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
     * @param EntityApiInterface|Network $entity_db
     * @param EntityApiInterface|Network $entity
     * @return EntityApiInterface|Network
     */
    public function mergeEntity(EntityApiInterface $entity_db, EntityApiInterface $entity): EntityApiInterface
    {
        return $entity_db->setNetworkAdmin($entity->getNetworkAdmin())->setNetworkEntity($entity->getNetworkEntity());
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|Network
     * @throws ClassNotFoundException
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
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

    /**
     * {@inheritDoc}
     */
    public function getByDataIdentification(array $parameters): ?EntityApiInterface
    {
        $parameters= $this->getDataIdentificationArray($parameters);
        return $this->getRepository()->findOneByAddress($parameters['address']);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(array $parameters): array
    {
        return ['address' => $parameters['address']];
    }
}
