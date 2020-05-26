<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use CertUnlp\NgenBundle\Model\EntityApiFrontendInterface;
use Closure;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\MappedSuperclass()
 */
abstract class EntityApiFrontend extends EntityApi implements EntityApiFrontendInterface
{

    /**
     * @return string
     */
    abstract public function getIcon(): string;


    /**
     * @return string
     */
    abstract public function getColor(): string;

    /**
     * @param Collection $collection
     * @param Closure $callback
     * @return array
     */
    public function getRatio(Collection $collection, Closure $callback): array
    {
        $ratio = [];
        foreach ($collection as $colectee) {
            if (isset($ratio[$callback($colectee)])) {
                $ratio[$callback($colectee)]++;
            } else {
                $ratio[$callback($colectee)] = 1;
            }
        }

        $percentages = [];
        foreach ($ratio as $key => $value) {
            $percentages[] = [$key, $value];
        }

        return $percentages;
    }


}
