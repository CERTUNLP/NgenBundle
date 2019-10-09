<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RtValues
 *
 * @ORM\Table(name="rt_values")
 * @ORM\Entity
 */
class RtValues
{
    /**
     * @var integer
     *
     * @ORM\Column(name="description", type="integer", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="expanded", type="string", length=45, nullable=false)
     */
    private $expanded;

    /**
     * @var string
     *
     * @ORM\Column(name="predicate", type="string", length=45, nullable=false)
     */
    private $predicate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=45)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $value;


}

