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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 *
 * @author dam
 * @method prePersistDelegation(Incident $incident)
 * @method postPersistDelegation(Incident $incident)
 * @method postUpdateDelegation(Incident $incident)
 */
class DelegatorChain
{

    private $delegates = array();

    /**
     * @param array $delegates
     */
    public function addDelegates(array $delegates = []): void
    {
        foreach ($delegates as $delegate) {
            $this->addDelegate($delegate);
        }
    }

    /**
     * @param $delegate
     * @param null $alias
     * @param null $priority
     */
    public function addDelegate($delegate, $alias = null, $priority = null): void
    {
        $delegateWrapper = new DelegateWrapper($delegate, $alias, $priority);
        if (isset($this->delegates[$delegateWrapper->getDelegateKey()])) {
            throw new Exception('Key ' . $delegateWrapper->getDelegateKey() . ' already in use.');
        }
        $this->delegates[$delegateWrapper->getDelegateKey()] = $delegateWrapper;
        $this->sortDelegatesByPriority();
    }


    /**
     *
     */
    public function sortDelegatesByPriority(): void
    {
        usort($this->delegates, static function ($a, $b) {
            return strcmp($a->getPriority(), $b->getPriority());
        });
    }

    /**
     * @param DelegateInterface $delegate
     */
    public function removeDelegate(DelegateInterface $delegate): void
    {
        if (isset($this->delegates[$delegate->getDelegateKey()])) {
            unset($this->delegates[$delegate->getDelegateKey()]);
        }
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $delegation_method = $this->explodeDelegationMethod($name);
        if ($delegation_method) {
            $this->doDelegation($delegation_method, $arguments);
        } else {
            throw new Exception('DelegatorChain Exeption: The method ' . $name . ' is not a delegation method.');
        }
    }

    /**
     * @param $delegation_method
     * @return string|null
     */
    private function explodeDelegationMethod(string $delegation_method): ?string
    {
        $explode = explode(',', preg_replace('/([a-z0-9])([A-Z])/', '$1,$2', $delegation_method));

        if (isset($explode[count($explode) - 1]) && $explode[count($explode) - 1] === "Delegation") {
            return $delegation_method;
        }

        return null;
    }

    /**
     * @param $function
     * @param $arguments
     */
    public function doDelegation(string $function, array $arguments): void
    {
        foreach ($this->delegates as $delegate) {
            $delegate->doDelegation($function, $arguments[0]);
        }
    }

}
