<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class UserChangePassword {

    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should by at least 6 chars long"
     * )
     */
    protected $newPassword;

    /**
     * Set oldPassword
     *
     * @param string $oldPassword
     * @return ChangePassword
     */
    public function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * Get oldPassword
     *
     * @return string 
     */
    public function getOldPassword() {
        return $this->oldPassword;
    }

    /**
     * Set newPassword
     *
     * @param string $newPassword
     * @return ChangePassword
     */
    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
        return $this;
    }

    /**
     * Get newPassword
     *
     * @return string 
     */
    public function getNewPassword() {
        return $this->newPassword;
    }

}
