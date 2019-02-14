<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Network;

use CertUnlp\NgenBundle\Entity\Network\Network;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class NetworkController extends FOSRestController
{

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
     * List all networks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\RequestParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing networks.")
     * @FOS\RequestParam(name="limit", requirements="\d+", nullable=true, description="How many networks to return.")
     *
     * @FOS\View(
     *  templateVar="networks"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getNetworksAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.network.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Network for a given host address",
     *   output = "CertUnlp\NgenBundle\Entity\Network\Network",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param Network $network
     * @return Network
     *
     * @FOS\Get("/networks/host/{ip}",requirements={"ip"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$"} )
     *
     * @FOS\View(
     *  templateVar="network"
     * )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findByAddress"})
     */
    public function getNetworkHostAction(Network $network)
    {
        return $network;
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Network for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Network\Network",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param Network $network
     * @return Network
     *
     * @FOS\Get("/networks/{domain}", name="_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Get("/networks/{ip_v4}/{ip_v4_mask}", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_v4_mask"="^[1-3]?[0-9]$"} )
     * @FOS\Get("/networks/{ip_v6}/{ip_v6_mask}", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_v6_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     * @FOS\View(
     *  templateVar="network"
     * )
     */
    public function getNetworkAction(Network $network)
    {
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
     * @FOS\View(
     *  templateVar = "network"
     * )
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postNetworkAction(Request $request)
    {
        return $this->getApiController()->post($request);
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
     *  templateVar = "network"
     * )
     *
     * @param Request $request the request object
     * @param Network $network
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/networks/{domain}", name="_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Patch("/networks/{ip_v4}/{ip_v4_mask}", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_v4_mask"="^[1-3]?[0-9]$"} )
     * @FOS\Patch("/networks/{ip_v6}/{ip_v6_mask}", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_v6_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     */
    public function patchNetworkAction(Request $request, Network $network)
    {
        return $this->getApiController()->patch($request, $network, true);
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
     *
     * @param Request $request the request object
     * @param Network $network
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/networks/{domain}/activate", name="_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Patch("/networks/{ip_v4}/{ip_v4_mask}/activate", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_v4_mask"="^[1-3]?[0-9]$"} )
     * @FOS\Patch("/networks/{ip_v6}/{ip_v6_mask}/activate", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_v6_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     * @FOS\View(
     *  templateVar = "network"
     * )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneBy"})
     */
    public function patchNetworkActivateAction(Request $request, Network $network)
    {

        return $this->getApiController()->activate($request, $network);
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
     *
     * @param Request $request the request object
     * @param Network $network
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/networks/{domain}/desactivate", name="_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Patch("/networks/{ip_v4}/{ip_v4_mask}/desactivate", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$","ip_v4_mask"="^[1-3]?[0-9]$"} )
     * @FOS\Patch("/networks/{ip_v6}/{ip_v6_mask}/desactivate", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$","ip_v6_mask"="^(([0-9]|[1-9][0-9]|1[0-1][0-9]|12[0-8]))$"} )
     * @FOS\View(
     *  templateVar = "network"
     * )
     * @ParamConverter("network", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneBy"})
     */
    public function patchNetworkDesactivateAction(Request $request, Network $network)
    {

        return $this->getApiController()->desactivate($request, $network);
    }

}
