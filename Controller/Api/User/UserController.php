<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\User;

use CertUnlp\NgenBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractFOSRestController
{
    public function __construct()
    {
    }

    /**
     * List all users.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher)
    {

        return null;
    }

    /**
     * List all users.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\RequestParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing users.")
     * @FOS\RequestParam(name="limit", requirements="\d+", nullable=true, description="How many users to return.")
     *
     * @FOS\View(
     *  templateVar="users"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getUsersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.user.api.controller');
    }

    /**
     * Gets a User for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a User for a given host address",
     *   output = "CertUnlp\NgenBundle\Entity\User",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @param User $user
     * @return User
     *
     * @FOS\Get("/users/{username}")
     *
     * @FOS\View(
     *  templateVar="user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * Create a User from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new user from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\UserType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postUserAction(Request $request)
    {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing user from the submitted data or create a new user at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  templateVar = "user"
     * )
     *
     * @param Request $request the request object
     * @param User $user
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/users/{username}")
     *
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserAction(Request $request, User $user)
    {
        return $this->getApiController()->patch($request, $user);
    }

    /**
     * Update existing user from the submitted data or create a new user at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param User $user
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/users/{username}/activate")
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserActivateAction(Request $request, User $user)
    {

        return $this->getApiController()->activate($request, $user);
    }

    /**
     * Update existing user from the submitted data or create a new user at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param User $user
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/users/{username}/desactivate")
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserDesactivateAction(Request $request, User $user)
    {

        return $this->getApiController()->desactivate($request, $user);
    }

}
