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

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use CertUnlp\NgenBundle\Entity\User;

/**
 *
 * @author demyen
 */
interface ReporterInterface
{

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname();


    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username);

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername();

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();
}
