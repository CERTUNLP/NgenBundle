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

class UserFrontendController extends Controller {

    /**
     * @Route("/login", name="cert_unlp_ngen_user_login")
     */
    public function loginAction(Request $peticion) {
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
        return $this->render('CertUnlpNgenBundle:User:Frontend/login.html.twig', array(
                    'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
                    'error' => $error
        ));
    }

    /**
     * @Route("/login_check", name="cert_unlp_ngen_user_login_check")
     */
    public function loginCheckAction() {
        return $this->redirect($this->generateUrl('cert_unlp_ngen_incident_frontend_home'));
    }

    /**
     * @Route("/logout", name="cert_unlp_ngen_user_logout")
     */
    public function logoutAction() {
        return $this->redirect($this->generateUrl('cert_unlp_ngen_incident_frontend_home'));
    }

    /**
     * @Route("/password_change", name="cert_unlp_ngen_user_password_change")
     */
    public function changePasswdAction(Request $request) {
        $changePasswordModel = new UserChangePassword();
        $form = $this->createForm(new UserChangePasswordType(), $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.context')->getToken()->getUser();

            $passwordEnClaro = $changePasswordModel->getNewPassword();
            $salt = md5(time());
            $encoder = $this->container->get('security.encoder_factory')
                    ->getEncoder($user);
            $password = $encoder->encodePassword($passwordEnClaro, $salt);
            $user->setPassword($password);
            $user->setSalt($salt);


            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('cert_unlp_ngen_user_logout'));
        }

        return $this->render('CertUnlpNgenBundle:User:Frontend/changePasswd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
