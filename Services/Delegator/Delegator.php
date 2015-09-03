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
class Delegator {

    private $delegates = array();

    public function __construct($delegates) {

        $this->addDelegates($delegates);
    }

    public function addDelegate(DelegateInterface $delegate) {

        if (isset($this->delegates[$delegate->getDelegateKey()])) {
            throw new Exception("Key " . $delegate->getDelegateKey() . " already in use.");
        } else {
            $this->delegates[$delegate->getDelegateKey()] = $delegate;
        }
    }

    public function addDelegates($delegates = []) {
        foreach ($delegates as $delegate) {
            $delegateWrapper = new DelegateWrapper($delegate);
            $this->addDelegate($delegateWrapper);
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
            throw new Exception("Delegator Exeption: The method " . $name . " is not a delegation method.");
        }
    }

}
