<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Model;

abstract class AbstractAnalyzer {

    public function analyze($params = null) {
        $this->output($this->doAnalysis($this->input($params)));
    }

    abstract public function input($params = null);

    public function doAnalysis($input = null) {
        return $input;
    }

    abstract public function output($analyze_output = null);
}
