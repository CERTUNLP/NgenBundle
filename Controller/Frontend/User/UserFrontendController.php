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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Form\UserType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_user_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_user
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_user): array
    {
        return $this->homeEntity($request, $elastica_finder_user);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/home.html.twig")
     * @Route("/search", name="cert_unlp_ngen_user_search_user")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_user
     * @return array
     */
    public function searchUserAction(Request $request, PaginatedFinderInterface $elastica_finder_user): array
    {
        return $this->searchEntity($request, $elastica_finder_user);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_user_new_user")
     * @param Request $request
     * @param UserType $user_type
     * @return array
     */
    public function newUserAction(Request $request, UserType $user_type): array
    {
        return $this->newEntity($request, $user_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userForm.html.twig")
     * @Route("/edit/{username}", name="cert_unlp_ngen_user_edit_user")
     * @param User $user
     * @param UserType $user_type
     * @return array
     */
    public function editUserAction(User $user, UserType $user_type): array
    {
        return $this->editEntity($user, $user_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:User:Frontend/userDetail.html.twig")
     * @Route("/{username}/detail", name="cert_unlp_ngen_user_detail_user")
     * @param User $user
     * @return array
     */
    public function datailUserAction(User $user): array
    {
        return $this->detailEntity($user);
    }

}
