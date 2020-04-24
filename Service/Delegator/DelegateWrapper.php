<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Delegator;

/**
 * Description of Delegate
 *
 * @author demyen
 */
class DelegateWrapper implements DelegateInterface
{

    private $delegateKey;
    private $delegate;
    private $alias;
    private $priority;

    public function __construct($delegate, $alias = null, $priority = null)
    {
        $this->setDelegate($delegate);
        $this->setAlias($alias);
        $this->setPriority($priority);
    }

    public function getDelegate()
    {
        return $this->delegate;
    }

    public function setDelegate($delegate)
    {
        $this->setDelegateKey(get_class($delegate));
        $this->delegate = $delegate;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getDelegateKey()
    {
        return $this->delegateKey . ($this->getAlias() ? ('.' . $this->getAlias()) : '');
    }

    public function setDelegateKey($delegateKey)
    {
        $this->delegateKey = $delegateKey;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function doDelegation($function, $arguments)
    {
        if (is_callable(array($this->delegate, $function))) {
            call_user_func(array($this->delegate, $function), $arguments);
        }
    }

//put your code here
}
