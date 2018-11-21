<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\User;

use FOS\UserBundle\Controller\SecurityController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserSecurityFrontendController extends SecurityController
{
    public function __construct()
    {
    }

    /**
     * @Route("/login", name="fos_user_security_login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        return parent::loginAction($request);
    }

    /**
     * @Route("/login_check", name="fos_user_security_check")
     */
    public function checkAction()
    {
        return $this->redirect("/");
    }

    /**
     * @Route("/logout", name="fos_user_security_logout")
     */
    public function logoutAction()
    {
        return parent::logoutAction();
    }

    protected function renderLogin(array $data)
    {
        return $this->render('CertUnlpNgenBundle:User:Frontend/login.html.twig', $data);
    }

}
