<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Repository\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\Network;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\NetworkElement;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NetworkRepository extends NetworkElementRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Network::class);
    }

    /**
     * @param string $address
     * @return Query
     */
    public function queryInRangeIpV4(string $address): Query
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('n')
            ->from($this->getClassName(), 'n')
            ->where($qb->expr()->between('INET_ATON(:address)', 'INET_ATON(n.ip_start_address)', 'INET_ATON(n.ip_end_address)'))
            ->andWhere('n.active = true')
            ->orderBy('n.ip_mask', 'DESC');

        $qb->setParameter('address', $address);

        return $qb->getQuery();
    }

    /**
     * @param string $address
     * @return Query
     */
    public function queryInRangeIpV6(string $address): Query
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('n')
            ->from($this->getClassName(), 'n')
            ->where($qb->expr()->between('INET6_ATON(:address)', 'INET6_ATON(n.ip_start_address)', 'INET6_ATON(n.ip_end_address)'))
            ->andWhere('n.active = true')
            ->orderBy('n.ip_mask', 'DESC');

        $qb->setParameter('address', $address);

        return $qb->getQuery();

    }

    /**
     * @param string $domain
     * @return Query
     */
    public function queryInRangeDomain(string $domain): Query
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('n')
            ->from($this->getClassName(), 'n')
            ->andWhere('n.active = true')
            ->orderBy('LENGTH(n.domain)', 'DESC');

        $count = substr_count($domain, '.') + 1;

        $qb->where($qb->expr()->eq('SUBSTRING_INDEX(:domain,\'.\',:count1 )', 'n.domain'));
        $qb->setParameter('count1', -1);

        for ($i = $count; $i > 1; $i--) {
            $qb->orWhere($qb->expr()->eq('SUBSTRING_INDEX(:domain,\'.\',:count' . $i . ')', 'n.domain'));
            $qb->setParameter('count' . $i, $i * -1);
        }

        $qb->setParameter('domain', $domain);

        return $qb->getQuery();

    }

    /**
     * @param string $address
     * @return NetworkElement|null| object
     */
    public function findOneByIp(string $address): ?NetworkElement
    {
        [$ip, $mask] = explode('/', $address);
        switch (Network::guessType($ip)) {
            case FILTER_FLAG_IPV6:
            case FILTER_FLAG_IPV4:
                if (isset($mask)) {
                    return $this->findOneBy(['ip' => $ip, 'ip_mask' => $mask]);
                }
                return $this->findOneBy(['ip' => $ip]);
            default:
                return null;
        }
    }
}
