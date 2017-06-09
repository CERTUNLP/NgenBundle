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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CertUnlp\NgenBundle\Form\UserType;
use CertUnlp\NgenBundle\Entity\User;

class UserFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.user.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_user_frontend_home")
     */
    public function homeAction(Request $request) {
        return $this->getFrontendController()->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/search", name="cert_unlp_ngen_user_search_user")
     */
    public function searchUserAction(Request $request) {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_user_new_user")
     */
    public function newUserAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/{username}/edit", name="cert_unlp_ngen_user_edit_user")
     */
    public function editUserAction(User $user) {
        return $this->getFrontendController()->editEntity($user);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userDetail.html.twig")
     * @Route("/{username}/detail", name="cert_unlp_ngen_user_detail_user")
     */
    public function datailUserAction(User $user) {
        return $this->getFrontendController()->detailEntity($user);
    }

}
