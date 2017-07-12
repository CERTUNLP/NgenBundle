<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CertUnlp\NgenBundle\Services\Mailer\OpenPGP;

/**
 * Message Signer used to apply OpenPGP Signature/Encryption to a message.
 *
 * @author Artem Zhuravlev <infzanoza@gmail.com>
 */
class IncidentOpenPGPSigner {

    protected $open_pgp_signer = null;

    public function __construct($open_pgp_signer, $private_key, $public_key) {
        $this->open_pgp_signer = $open_pgp_signer;
        $this->private_key = $private_key;
        $this->public_key = "/home/cert/public2.key";
//        var_dump($this->public_key);die;
        $this->open_pgp_signer->import(file_get_contents($this->private_key));
        $this->open_pgp_signer->import(file_get_contents($this->public_key));
    }

    public function sign(\Swift_Message $message, $encrypt = false) {
        $this->open_pgp_signer->setEncrypt($encrypt);
//        var_dump($this->open_pgp_signer);die;
//        var_dump($this->open_pgp_signer,$this);die;
        $message->attachSigner($this->open_pgp_signer);
//        $message->attach(\Swift_Attachment::fromPath($this->public_key));
    }

}
