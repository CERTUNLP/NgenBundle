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

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Service\Api\Handler\UserHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     * @param UserHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(UserHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Get status.",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
     * )
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return array
     */
    public function getAction(ParamFetcherInterface $paramFetcher)
    {
        return null;
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="List all users.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="body",
     *         description="Offset from which to start listing users.",
     *         required=false,
     *         @SWG\Schema(type="\d+")
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="body",
     *         description="How many users to return.",
     *         required=false,
     *         @SWG\Schema(type="\d+")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\RequestParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing users.")
     * @FOS\RequestParam(name="limit", requirements="\d+", nullable=true, description="How many users to return.")
     * @FOS\View(
     *  templateVar="users"
     * )
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getUsersAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Gets a User for a given host address",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the user is not found"
     *     )
     * )
     * @param User $user
     * @return View
     * @FOS\Get("/users/{username}")
     * @FOS\View(
     *  templateVar="user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function getUserAction(User $user): View
    {
        return $this->response([$user]);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Creates a new user from the submitted data.",
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="form.email",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="form.username",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="plainPassword",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="object (RepeatedType)"
     *     ),
     *     @SWG\Parameter(
     *         name="firstname",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="lastname",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="roles",
     *         in="formData",
     *         description="Roles",
     *         required=false,
     *         type="array of choices"
     *     ),
     *     @SWG\Parameter(
     *         name="contacts",
     *         in="formData",
     *         description="Contacts",
     *         required=false,
     *         type="array of objects (ContactType)"
     *     ),
     *     @SWG\Parameter(
     *         name="save",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @param Request $request the request object
     * @return View
     */
    public function postUserAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing user from the submitted data or create a new user at a specific location.",
     *     @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="form.email",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="body",
     *         description="form.username",
     *         required=true,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="plainPassword",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (RepeatedType)")
     *     ),
     *     @SWG\Parameter(
     *         name="firstname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="lastname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="roles",
     *         in="body",
     *         description="Roles",
     *         required=false,
     *         @SWG\Schema(type="array of choices")
     *     ),
     *     @SWG\Parameter(
     *         name="contacts",
     *         in="body",
     *         description="Contacts",
     *         required=false,
     *         @SWG\Schema(type="array of objects (ContactType)")
     *     ),
     *     @SWG\Parameter(
     *         name="save",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @param Request $request the request object
     * @param User $user
     * @return View
     * @FOS\Patch("/users/{username}")
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserAction(Request $request, User $user): View
    {
        return $this->patch($request, $user);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing user from the submitted data or create a new user at a specific location.",
     *     @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="form.email",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="body",
     *         description="form.username",
     *         required=true,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="plainPassword",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (RepeatedType)")
     *     ),
     *     @SWG\Parameter(
     *         name="firstname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="lastname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="roles",
     *         in="body",
     *         description="Roles",
     *         required=false,
     *         @SWG\Schema(type="array of choices")
     *     ),
     *     @SWG\Parameter(
     *         name="contacts",
     *         in="body",
     *         description="Contacts",
     *         required=false,
     *         @SWG\Schema(type="array of objects (ContactType)")
     *     ),
     *     @SWG\Parameter(
     *         name="save",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param User $user
     * @return View
     * @FOS\Patch("/users/{username}/activate")
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserActivateAction(Request $request, User $user): View
    {
        return $this->activate($request, $user);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing user from the submitted data or create a new user at a specific location.",
     *     @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="form.email",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="body",
     *         description="form.username",
     *         required=true,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="plainPassword",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (RepeatedType)")
     *     ),
     *     @SWG\Parameter(
     *         name="firstname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="lastname",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Parameter(
     *         name="roles",
     *         in="body",
     *         description="Roles",
     *         required=false,
     *         @SWG\Schema(type="array of choices")
     *     ),
     *     @SWG\Parameter(
     *         name="contacts",
     *         in="body",
     *         description="Contacts",
     *         required=false,
     *         @SWG\Schema(type="array of objects (ContactType)")
     *     ),
     *     @SWG\Parameter(
     *         name="save",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="string")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param User $user
     * @return View
     * @FOS\Patch("/users/{username}/desactivate")
     * @FOS\View(
     *  templateVar = "user"
     * )
     * @ParamConverter("user", class="CertUnlpNgenBundle:User", options={"repository_method" = "findOneBy"})
     */
    public function patchUserDesactivateAction(Request $request, User $user): View
    {
        return $this->desactivate($request, $user);
    }

}
