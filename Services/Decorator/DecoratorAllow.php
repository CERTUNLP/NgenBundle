<?php

namespace CertUnlp\NgenBundle\Services\Decorator;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
class DecoratorAllow extends DecoratorAbstract
{
    /**
     * @var array
     */
    private $allowedMethods;
    /**
     * @var bool
     */
    private $inversedBehavior;

    public function __construct(array $allowedMethods = [], bool $inversedBehavior = false)
    {
        $this->allowedMethods = $allowedMethods;
        $this->inversedBehavior = $inversedBehavior;
    }

    /**
     * @return bool
     */
    public function inverseBehavior(): bool
    {
        return $this->inversedBehavior = !$this->inversedBehavior;
    }

    /**
     * @return bool
     */
    public function isInversedBehavior(): bool
    {
        return $this->inversedBehavior;
    }

    /**
     * @param bool $inversedBehavior
     * @return DecoratorAllow
     */
    public function setInversedBehavior(bool $inversedBehavior): DecoratorAllow
    {
        $this->inversedBehavior = $inversedBehavior;
        return $this;
    }

    /**
     * @param string $method
     * @return DecoratorAllow
     */
    public function addAllowedMethod(string $method): self
    {
        $this->getAllowedMethods()[] = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @param mixed $allowedMethods
     * @return DecoratorAllow
     */
    public function setAllowedMethods(array $allowedMethods): self
    {
        $this->allowedMethods = $allowedMethods;
        return $this;
    }

    /**
     * @param $method
     * @param $args
     * @return bool
     */
    private function canDecorate($method, $args): bool
    {
        return in_array($method, $this->getAllowedMethods(), true);
    }
}
