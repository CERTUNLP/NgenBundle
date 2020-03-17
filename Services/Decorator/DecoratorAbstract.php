<?php

namespace CertUnlp\NgenBundle\Services\Decorator;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
abstract class DecoratorAbstract
{


    /**
     * @var mixed
     */
    private $object = null;

    public function __call($method, $args)
    {
        if ($this->canDecorate($method, $args) && is_callable($this->getObject(), $method)) {
            return $this->decorate($this->getObject(), $method, $args);
        }
        return null;
    }

    private function canDecorate($method, $args): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return mixed
     */
    public function decorate($object, $method, $args)
    {
        return call_user_func_array(array($object, $method), $args);
    }

    public function getOriginalObject()
    {
        $object = $this->object;
        while ($object instanceof self) {
            $object = $object->getOriginalObject();
        }
        return $object;
    }

    /**
     * @param mixed $component
     * @return DecoratorAbstract
     */
    public function setComponent($component)
    {
        $this->object = $component;
        return $this;
    }

}
