<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Form\Model\UserChangePassword;
use CertUnlp\NgenBundle\Form\UserChangePasswordType;
use FOS\UserBundle\Controller\SecurityController;

class UserSecurityFrontendController extends SecurityController {

    /**
     * @Route("/login", name="fos_user_security_login")
     */
    public function loginAction(Request $request) {
        return parent::loginAction($request);
    }

    protected function renderLogin(array $data) {
        return $this->render('CertUnlpNgenBundle:User:Frontend/login.html.twig', $data);
    }

    /**
     * @Route("/login_check", name="fos_user_security_check")
     */
    public function checkAction() {
        return $this->redirect("/");
    }

    /**
     * @Route("/logout", name="fos_user_security_logout")
     */
    public function logoutAction() {
        return parent::logoutAction();
    }

}
