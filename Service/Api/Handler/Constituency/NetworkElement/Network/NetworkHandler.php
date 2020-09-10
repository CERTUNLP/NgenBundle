<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\Network;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Form\Constituency\NetworkElement\NetworkType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\Constituency\NetworkElement\NetworkRepository;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement\NetworkElementHandler;
use CertUnlp\NgenBundle\Service\NetworkRdapClient;
use Doctrine\ORM\EntityManagerInterface;
use Metaregistrar\RDAP\RdapException;
use Symfony\Component\Form\FormFactoryInterface;

class NetworkHandler extends NetworkElementHandler
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
     * @param string $address
     * @param bool $rdap_lookup
     * @return Network|null
     */
    public function findOneInRange(string $address, bool $rdap_lookup = false): ?Network
    {
        $network = $this->getRepository()->findOneInRange($address);

        if (!$network && $rdap_lookup) {
            try {
                $network = $this->getNetworkRdapHandler()->search($address);
            } catch (RdapException $e) {
                $network = null;
            }
        }
        if (!$network) {
            $network = $this->getDefaultNetwork();
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
     * @return EntityApiInterface|Network
     */
    public function getDefaultNetwork(): Network
    {
        return $this->get(['ip_mask' => '0']);
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|Network
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
    {
        $class_name = $this->getRepository()->getClassName();
        return new $class_name($parameters['address']);
    }


}
