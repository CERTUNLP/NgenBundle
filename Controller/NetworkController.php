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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CertUnlp\NgenBundle\Form\NetworkType;
use CertUnlp\NgenBundle\Entity\Network;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Exception\InvalidFormException;

class NetworkController extends FOSRestController {

    /**
     * List all networks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher) {

        return null;
    }

    /**
     * List all networks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing networks.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="5", description="How many networks to return.")
     *
     * @FOS\View(
     *  templateVar="networks"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getNetworksAction(Request $request, ParamFetcherInterface $paramFetcher) {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('cert_unlp.ngen.network.handler')->all([], [], $limit, $offset);
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Network for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Network",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param int     $id      the network id
     *
     * @return array
     *
     * @throws NotFoundHttpException when network not exist
     *
     * @FOS\Get("/networks/{ip}/{ipMask}")
     *
     * @ParamConverter("network", class="CertUnlpNgenBundle:Network", options={"repository_method" = "findOneBy"})
     * @FOS\QueryParam(name="ip",strict=true ,requirements="[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", description="An IP.")
     * @FOS\QueryParam(name="ipMask",strict=true ,requirements="[0-32]", description="A decimal ip mask.")
     */
    public function getNetworkAction(Network $network) {
        return $network;
    }

    /**
     * Create a Network from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new network from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postNetworkAction(Request $request) {
        try {
            $network = $this->container->get('cert_unlp.ngen.network.handler')->post(
                    $request->request->all()
            );
            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_network', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  template = "CertUnlpNgenBundle:Network:editNetwork.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @FOS\Patch("/networks/{ip}/{ipMask}")
     *
     * @ParamConverter("network", class="CertUnlpNgenBundle:Network", options={"repository_method" = "findOneBy"})
     * @FOS\QueryParam(name="ip",strict=true ,requirements="[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", description="An IP.")
     * @FOS\QueryParam(name="ipMask",strict=true ,requirements="[0-32]", description="A decimal ip mask.")
     */
    public function patchNetworkAction(Request $request, Network $network) {
        try {

            $parameters = $request->request->all();
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);


            $DBnetwork = $this->container->get('cert_unlp.ngen.network.handler')->get(['ip' => $request->request->get('ip'), 'ipMask' => $request->request->get('ipMask')]);

            if ($request->get('reactivate')) {
                $network->setIsActive(TRUE);
            }

            if (!$network->equals($DBnetwork)) {
                if ($request->get('force_edit')) {
                    $statusCode = Codes::HTTP_NO_CONTENT;

                    $network = $this->container->get('cert_unlp.ngen.network.handler')->patch($network, $parameters);
                } else {
                    $statusCode = Codes::HTTP_CREATED;
                    $this->container->get('cert_unlp.ngen.network.handler')->delete($network);
                    $network = $this->container->get('cert_unlp.ngen.network.handler')->post($parameters);
                }
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;

                $network = $this->container->get('cert_unlp.ngen.network.handler')->patch($network, $parameters);
            }

            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_network', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * 
     * @FOS\Patch("/networks/{ip}/{ipMask}/activate")
     *
     * @ParamConverter("network", class="CertUnlpNgenBundle:Network", options={"repository_method" = "findOneBy"})
     * @FOS\QueryParam(name="ip",strict=true ,requirements="[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", description="An IP.")
     * @FOS\QueryParam(name="ipMask",strict=true ,requirements="[0-32]", description="A decimal ip mask.")
     */
    public function patchNetworkActivateAction(Request $request, Network $network) {

        try {
            $network = $this->container->get('cert_unlp.ngen.network.handler')->activate($network);
            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );
            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_network', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return $this->routeRedirectView('api_1_get_network', $routeOptions, Codes::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * 
     * @FOS\Patch("/networks/{ip}/{ipMask}/desactivate")
     *
     * @ParamConverter("network", class="CertUnlpNgenBundle:Network", options={"repository_method" = "findOneBy"})
     * @FOS\QueryParam(name="ip",strict=true ,requirements="[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}", description="An IP.")
     * @FOS\QueryParam(name="ipMask",strict=true ,requirements="[0-32]", description="A decimal ip mask.")
     */
    public function patchNetworkDesactivateAction(Request $request, Network $network) {

        try {
            $network = $this->container->get('cert_unlp.ngen.network.handler')->delete($network);

            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_network', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return $this->routeRedirectView('api_1_get_network', $routeOptions, Codes::HTTP_BAD_REQUEST);
        }
    }

}
