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
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_user_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/search", name="cert_unlp_ngen_user_search_user")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchUserAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_user_new_user")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newUserAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/edit/{username}", name="cert_unlp_ngen_user_edit_user")
     * @param User $user
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editUserAction(User $user, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($user);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userDetail.html.twig")
     * @Route("/{username}/detail", name="cert_unlp_ngen_user_detail_user")
     * @param User $user
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function datailUserAction(User $user, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($user);
    }

}
