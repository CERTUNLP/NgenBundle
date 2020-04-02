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


    public function __call(string $method, array $args = [])
    {

        if (strpos($method, 'get') !== 0) {
            $method = 'get' . ucfirst($method);
        }

        if ($this->canDecorate($method, $args) && is_callable([$this->getObject(), $method])) {
            return $this->decorate($this->getObject(), $method, $args);
        }
        return null;
    }

    public function canDecorate(string $method, array $args = []): bool
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
     * @param mixed $object
     * @return DecoratorAbstract
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @param $object
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function decorate($object, string $method, array $args = [])
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

}
