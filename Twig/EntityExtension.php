<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Twig;

use CertUnlp\NgenBundle\Model\EntityInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityExtension extends AbstractExtension
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('list_headers', array($this, 'getListHeaders')),
            new TwigFunction('getIconForStateAction', array($this, 'getIconForStateAction')),

        );
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function getListHeaders(EntityInterface $entity): array
    {
        return array_keys(json_decode($this->getSerializer()->serialize($entity, 'json', SerializationContext::create()->setGroups(array('list'))->setSerializeNull(true)), true));
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Twig Entity Extensions';
    }
}
