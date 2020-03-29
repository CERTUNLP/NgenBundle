<?php

namespace CertUnlp\NgenBundle\Services\Decorator;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
abstract class DecoratorAllow extends DecoratorAbstract
{

    /**
     * @param $method
     * @param $args
     * @return bool
     */
    public function canDecorate(string $method, array $args): bool
    {
        $allowed = in_array($method, $this->getAllowedMethods(), true);
        if ($this->inversedBehavior()) {
            return !$allowed;
        }
        return $allowed;
    }

    /**
     * @return array
     */
    abstract public function getAllowedMethods(): array;

    /**
     * @return bool
     */
    abstract public function inversedBehavior(): bool;
}
