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

use Closure;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
abstract class EntityApiFrontend extends EntityApi
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
