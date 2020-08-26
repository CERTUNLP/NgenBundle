<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\NetworkInternal;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\NetworkElement;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HostRepository extends NetworkElementRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Host::class);
    }

    /**
     * @param $address string
     * @param bool $limit_less_especific
     * @return NetworkElement|null
     */
    public function findOneInRange(string $address, bool $limit_less_especific = false): ?NetworkElement
    {
        switch (NetworkElement::guessType($address)) {
            case FILTER_FLAG_IPV4:
                return $this->findOneInRangeIpV4($address, $limit_less_especific);
            case FILTER_FLAG_IPV6:
                return $this->findOneInRangeIpV6($address, $limit_less_especific);
            case FILTER_VALIDATE_DOMAIN:
                return $this->findOneInRangeDomain($address, $limit_less_especific);
            default:
                return null;
        }
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement|null
     */
    public function findOneInRangeIpV4(string $address, bool $limit_less_especific = false): ?NetworkElement
    {
        $results = $this->queryInRangeIpV4($address)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return Query
     */
    public function queryInRangeIpV4(string $address, bool $limit_less_especific = false): Query
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('h')
            ->from($this->getClassName(), 'h')
            ->where($qb->expr()->between('INET_ATON(h.ip)', 'INET_ATON(:start_address)', 'INET_ATON(:end_address)'))
            ->andWhere('h.active = true');
        $network = new NetworkInternal($address);
        if ($limit_less_especific) {
            $qb->innerJoin('h.network', 'n')
                ->andWhere($qb->expr()->lte('n.ip_mask', ':mask'))
                ->andWhere($qb->expr()->neq('n.ip', ':ip'));
            $qb->setParameter('mask', (int)$network->getAddressMask());
            $qb->setParameter('ip', $network->getAddress());
        }

        $qb->setParameter('start_address', $network->getStartAddress());
        $qb->setParameter('end_address', $network->getEndAddress());

        return $qb->getQuery();
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement|null
     */
    public function findOneInRangeIpV6(string $address, bool $limit_less_especific = false): ?NetworkElement
    {
        $results = $this->queryInRangeIpV6($address, $limit_less_especific)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return Query
     */
    public function queryInRangeIpV6(string $address, bool $limit_less_especific = false): Query
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('h')
            ->from($this->getClassName(), 'h')
            ->where($qb->expr()->between('INET6_ATON(h.ip)', 'INET6_ATON(:start_address)', 'INET6_ATON(:end_address)'))
            ->andWhere('h.active = true')
            ->orderBy('h.ip_mask', 'DESC');

        $network = new NetworkInternal($address);
        if ($limit_less_especific) {
            $qb->innerJoin('h.network', 'n')
                ->andWhere($qb->expr()->lte('n.ip_mask', ':mask'))
                ->andWhere($qb->expr()->neq('n.ip', ':ip'));
            $qb->setParameter('mask', (int)$network->getAddressMask());
            $qb->setParameter('ip', $network->getAddress());
        }
        $qb->setParameter('start_address', $network->getStartAddress());
        $qb->setParameter('end_address', $network->getEndAddress());

        return $qb->getQuery();

    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement|null
     */
    public function findOneInRangeDomain(string $address, bool $limit_less_especific = false): ?NetworkElement
    {
        $results = $this->queryInRangeDomain($address, $limit_less_especific)->getResult();
        return $results ? $results[0] : null;
    }

    /**
     * @param string $domain
     * @param bool $limit_less_especific
     * @return Query
     */
    public function queryInRangeDomain(string $domain, bool $limit_less_especific = false): Query
    {
        [$domain] = explode('/', $domain);

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('h')
            ->from($this->getClassName(), 'h')
            ->andWhere('h.active = true')
            ->orderBy('LENGTH(h.domain)', 'DESC');

        if ($limit_less_especific) {
            $qb->innerJoin('h.network', 'n')
                ->andWhere($qb->expr()->lt('LENGTH(n.domain)', ':length'));
            $qb->setParameter('length', strlen($domain));
        }

        $count = substr_count($domain, '.') + 1;

        $qb->andWhere($qb->expr()->eq('SUBSTRING_INDEX(h.domain,\'.\',:count )', ':domain'));
        $qb->setParameter('count', $count * -1);

        $qb->setParameter('domain', $domain);

        return $qb->getQuery();

    }

    /**
     * @param $address string
     * @param bool $limit_less_especific
     * @return NetworkElement[]|null
     */
    public function findInRange(string $address, bool $limit_less_especific = false): ?array
    {
        switch (NetworkElement::guessType($address)) {
            case FILTER_FLAG_IPV4:
                return $this->findInRangeIpV4($address, $limit_less_especific);
            case FILTER_FLAG_IPV6:
                return $this->findInRangeIpV6($address, $limit_less_especific);
            case FILTER_VALIDATE_DOMAIN:
                return $this->findInRangeDomain($address, $limit_less_especific);
            default:
                return null;
        }
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement[]|null
     */
    public function findInRangeIpV4(string $address, bool $limit_less_especific = false): ?array
    {
        return $this->queryInRangeIpV4($address, $limit_less_especific)->getResult();
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement[]|null
     */
    public function findInRangeIpV6(string $address, bool $limit_less_especific = false): ?array
    {
        return $this->queryInRangeIpV6($address, $limit_less_especific)->getResult();
    }

    /**
     * @param string $address
     * @param bool $limit_less_especific
     * @return NetworkElement[]|null
     */
    public function findInRangeDomain(string $address, bool $limit_less_especific = false): ?array
    {
        return $this->queryInRangeDomain($address, $limit_less_especific)->getResult();
    }
}
