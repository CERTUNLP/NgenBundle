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

use CertUnlp\NgenBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_user_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.user.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/search", name="cert_unlp_ngen_user_search_user")
     * @param Request $request
     * @return array
     */
    public function searchUserAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_user_new_user")
     * @param Request $request
     * @return array
     */
    public function newUserAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/edit/{username}", name="cert_unlp_ngen_user_edit_user")
     * @param User $user
     * @return array
     */
    public function editUserAction(User $user)
    {
        return $this->getFrontendController()->editEntity($user);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userDetail.html.twig")
     * @Route("/{username}/detail", name="cert_unlp_ngen_user_detail_user")
     * @param User $user
     * @return array
     */
    public function datailUserAction(User $user)
    {
        return $this->getFrontendController()->detailEntity($user);
    }

}
