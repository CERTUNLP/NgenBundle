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

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CertUnlp\NgenBundle\Form\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IncidentController extends FOSRestController {

    /**
     * List all pages.
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
     * List all pages.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
     *
     * @Annotations\View(
     *  templateVar="incidents"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentsAction(Request $request, ParamFetcherInterface $paramFetcher) {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('cert_unlp.ngen.incident.handler')->all($limit, $offset);
    }

    /**
     * Get single Page.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Page for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="incident")
     *
     * @param int     $id      the page id
     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     * @Fos\Get("/incidents/{hostAddress}/{date}/{type}")
     *
     * @ParamConverter("incident", class="CertUnlpNgenBundle:Incident", options={"repository_method" = "findByHostDateType"})
     */
    public function getIncidentAction(Incident $incident) {
        return $incident;
    }

    /**
     * Presents the form to use to create a new page.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newIncidentAction() {
        return $this->createForm(new IncidentType());
    }

    /**
     * Create a Page from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new page from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="bulk", requirements="\d+", nullable=true, description="Indicates that this is a bulk post with various incidents.")
     * 
     * @Annotations\View(
     *  template = "CertUnlpNgenBundle:Incident:newIncident.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentAction(Request $request) {
        //TODO: refactoring aca o algo, poqnomegusta

        try {
            $incident_data = array_merge($request->request->all(), $request->files->all());
            if (!isset($incident_data['reporter'])) {
                $incident_data['reporter'] = $this->getUser()->getId();
            }
            $hostAddresses = explode(',', $incident_data['hostAddress']);
            if (count($hostAddresses) > 1) {

                foreach ($hostAddresses as $hostAddress) {
                    $incident_data['hostAddress'] = $hostAddress;
                    $this->get('cert_unlp.ngen.incident.handler')->post($incident_data);
                }
                $routeOptions = array(
                    '_format' => $request->get('_format')
                );

                return $this->routeRedirectView('api_1_get_incidents', $routeOptions, Codes::HTTP_CREATED);
            } else {

                $newIncident = $this->get('cert_unlp.ngen.incident.handler')->post($incident_data);

                $routeOptions = array(
                    'hostAddress' => $newIncident->getHostAddress(),
                    'type' => $newIncident->getType()->getSlug(),
                    'date' => $newIncident->getDate()->format('Y-m-d'),
                    '_format' => $request->get('_format')
                );
//                return View::create(null, Codes::HTTP_OK);

                return $this->routeRedirectView('api_1_get_incident', $routeOptions, Codes::HTTP_CREATED);
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing page from the submitted data or create a new page at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "CertUnlpNgenBundle:Incident:editIncident.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the page id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     * @FOS\Patch("/incidents/{hostAddress}/{date}/{type}/update")
     *
     * @ParamConverter("incident", class="CertUnlpNgenBundle:Incident", options={"repository_method" = "findByHostDateType"})
     */
    public function patchIncidentAction(Request $request, Incident $incident) {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $incident = $this->container->get('cert_unlp.ngen.incident.handler')->patch(
                    $incident, $parameters
            );

            $routeOptions = array(
                'hostAddress' => $incident->getHostAddress(),
                'type' => $incident->getType()->getSlug(),
                'date' => $incident->getDate()->format('Y-m-d'),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_incident', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing page from the submitted data or create a new page at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     201 = "Returned when the Incident is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "CertUnlpNgenBundle:Incident:editIncident.html.twig",
     * statusCode = Codes::HTTP_BAD_REQUEST,

     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the incident id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function putIncidentAction(Request $request, $id) {
        try {
            if (!($page = $this->container->get('cert_unlp.ngen.incident.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $page = $this->container->get('cert_unlp.ngen.incident.handler')->post(
                        $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $page = $this->container->get('cert_unlp.ngen.incident.handler')->put(
                        $page, $request->request->all()
                );
            }

            $routeOptions = array(
                'incident' => $page->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_incident', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing page from the submitted data or create a new page at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the page id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     * 
     */
    public function patchIncidentStateAction(Request $request, Incident $incident, \CertUnlp\NgenBundle\Entity\IncidentState $state) {

        try {
            $incident = $this->container->get('cert_unlp.ngen.incident.handler')->changeState(
                    $incident, $state);
            $routeOptions = array(
                'hostAddress' => $incident->getHostAddress(),
                'type' => $incident->getType()->getSlug(),
                'date' => $incident->getDate()->format('Y-m-d'),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_incident', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return $this->routeRedirectView('api_1_get_incident', $routeOptions, Codes::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update existing page from the submitted data or create a new page at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "CertUnlpNgenBundle:Incident:editIncident.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $incident      the page id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function deleteIncidentAction(Request $request, Incident $incident) {
        try {

            $statusCode = Codes::HTTP_NO_CONTENT;
            $incident = $this->container->get('cert_unlp.ngen.incident.handler')->delete(
                    $incident, $request->request->all()
            );

            $routeOptions = array(
                'incident' => $incident->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_new_incident', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

//    /**
//     * @Route("/", name="/api/ajax/request", options=")
//     */
//    public function apiRequestAction(Request $request, Incident $incident) {
//        
//    }
}
