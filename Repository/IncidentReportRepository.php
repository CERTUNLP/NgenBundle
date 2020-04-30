<?php

namespace CertUnlp\NgenBundle\Repository;

use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncidentReport::class);
    }
}
