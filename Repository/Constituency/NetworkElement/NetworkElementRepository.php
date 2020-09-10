<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\NetworkElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class NetworkElementRepository extends ServiceEntityRepository
{
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return NetworkElement|object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?NetworkElement
    {
        if (isset($criteria['address'])) {
            return $this->findOneByAddress($criteria['address']);
        }
        return parent::findOneBy($criteria, $orderBy);
    }

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
            case FILTER_VALIDATE_DOMAIN:
                return $this->findOneByDomain($address);
            default:
                return null;
        }
    }

    /**
     * @param $address string
     * @return NetworkElement|null
     */
    public function findOneInRange(string $address): ?NetworkElement
    {
        switch (NetworkElement::guessType($address)) {
            case FILTER_FLAG_IPV4:
                return $this->findOneInRangeIpV4($address);
            case FILTER_FLAG_IPV6:
                return $this->findOneInRangeIpV6($address);
            case FILTER_VALIDATE_DOMAIN:
                return $this->findOneInRangeDomain($address);
            default:
                return null;
        }
    }

    /**
     * @param string $address
     * @return NetworkElement|null
     */
    public function findOneInRangeIpV4(string $address): ?NetworkElement
    {
        $results = $this->queryInRangeIpV4($address)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param string $address
     * @return NetworkElement|null
     */
    public function findOneInRangeIpV6(string $address): ?NetworkElement
    {
        $results = $this->queryInRangeIpV6($address)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param string $address
     * @return NetworkElement|null
     */
    public function findOneInRangeDomain(string $address): ?NetworkElement
    {
        $results = $this->queryInRangeDomain($address)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param $address string
     * @return NetworkElement[]|null
     */
    public function findInRange(string $address): ?array
    {
        switch (NetworkElement::guessType($address)) {
            case FILTER_FLAG_IPV4:
                return $this->findInRangeIpV4($address);
            case FILTER_FLAG_IPV6:
                return $this->findInRangeIpV6($address);
            case FILTER_VALIDATE_DOMAIN:
                return $this->findInRangeDomain($address);
            default:
                return null;
        }
    }

    /**
     * @param string $address
     * @return NetworkElement[]|null
     */
    public function findInRangeIpV4(string $address): ?array
    {
        return $this->queryInRangeIpV4($address)->getResult();
    }

    /**
     * @param string $address
     * @return NetworkElement[]|null
     */
    public function findInRangeIpV6(string $address): ?array
    {
        return $this->queryInRangeIpV6($address)->getResult();
    }

    /**
     * @param string $address
     * @return NetworkElement[]|null
     */
    public function findInRangeDomain(string $address): ?array
    {
        return $this->queryInRangeDomain($address)->getResult();
    }

}
