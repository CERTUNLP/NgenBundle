<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Delegator;

use Symfony\Component\Config\Definition\Exception\Exception;
use CertUnlp\NgenBundle\Services\Delegator\DelegateWrapper;

/**
 *
 * @author demyen
 */
class DelegatorChain {

    private $delegates = array();

    public function addDelegate($delegate, $alias = null, $priority = null) {
        $delegateWrapper = new DelegateWrapper($delegate, $alias, $priority);
        if (isset($this->delegates[$delegateWrapper->getDelegateKey()])) {
            throw new Exception("Key " . $delegateWrapper->getDelegateKey() . " already in use.");
        } else {
            $this->delegates[$delegateWrapper->getDelegateKey()] = $delegateWrapper;
            $this->sortDelegatesByPriority();
        }
    }

    private function cmp($a, $b) {
        return strcmp($a->getPriority(), $b->getPriority());
    }

    public function sortDelegatesByPriority() {

        usort($this->delegates, array($this, 'cmp'));
    }

    public function addDelegates($delegates = []) {
        foreach ($delegates as $delegate) {
            $this->addDelegate($delegate);
        }
    }

    public function removeDelegate(DelegateInterface $delegate) {

        if (isset($this->delegates[$delegate->getDelegateKey()])) {
            unset($this->delegates[$delegate->getDelegateKey()]);
        }
    }

    public function doDelegation($function, $arguments) {
        foreach ($this->delegates as $delegate) {
            $delegate->doDelegation($function, $arguments);
        }
    }

    private function explodeDelegationMethod($delegation_method) {
        $explode = explode(",", preg_replace('/([a-z0-9])([A-Z])/', "$1,$2", $delegation_method));

        if (isset($explode[count($explode) - 1]) && $explode[count($explode) - 1] == "Delegation") {
            return $delegation_method;
        } else {
            return false;
        }
    }

    public function __call($name, $arguments) {
        $delegation_method = $this->explodeDelegationMethod($name);
        if ($delegation_method) {
            $this->doDelegation($delegation_method, $arguments);
        } else {
            throw new Exception("DelegatorChain Exeption: The method " . $name . " is not a delegation method.");
        }
    }

}
