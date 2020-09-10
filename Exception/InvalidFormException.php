<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Exception;

use RuntimeException;
use Symfony\Component\Form\Form;

class InvalidFormException extends RuntimeException
{

    protected $form;

    public function __construct($message = '', $form = null)
    {
        parent::__construct($message);
        $this->form = $form;
    }

    /**
     * @return Form
     */
    public function getForm(): ?Form
    {
        return $this->form;
    }

}
