<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Address;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\NetworkElement;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
class DomainAddress extends Address
{

    /**
     * {@inheritDoc}
     */
    public function inRange(Address $other = null): bool
    {
        if ($other && get_class($other) === get_class($this)) {
            $array = explode('.', $this->getCustomAddress());
            $array2 = explode('.', $other->getCustomAddress());

            if ($array === $array2) {
                return true;
            }
            if ($array > $array2) {
                return array_intersect($array, $array2) === $array2;
            }
//            return !count(array_diff(explode('.', $this->getCustomAddress()), explode('.', $other->getCustomAddress())));
        }
        return false;

    }

    /**
     * {@inheritDoc}
     */
    public function getCustomAddress(): string
    {
        return $this->getNetwork()->getDomain();
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomAddressMask(): ?int
    {
        return substr_count($this->getCustomAddress(), '.') + 1;
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomAddress(string $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        return $this->getNetwork();
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomAddressMask(int $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        return $this->getNetwork();
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return 'domain';
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomNumericAddress(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomNumericAddressMask(): int
    {
        return '';
    }

}
