<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\NetworkElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class NetworkElementRepository extends ServiceEntityRepository
{
    /**
     * @param string $address
     * @return NetworkElement|null| object
     */
    public function findOneByAddress(string $address): ?NetworkElement
    {
        switch (NetworkElement::guessType($address)) {
            case FILTER_FLAG_IPV6:
            case FILTER_FLAG_IPV4:
                return $this->findOneByIp($address);
                break;
            case FILTER_VALIDATE_DOMAIN:
                return $this->findOneByDomain($address);
                break;
            default:
                return null;
        }
    }

}
