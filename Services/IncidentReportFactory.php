<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class IncidentReportFactory
{

    protected $templating;
    private $viewHandler;
    private $view;
    private $team;
    private $custom_handler;

    public function __construct(Environment $templating, ViewHandler $viewHandler, View $view, $team)
    {
        $this->templating = $templating;
        $this->viewHandler = $viewHandler;
        $this->view = $view;
        $this->team = $team;
    }

    public function getReport(Incident $incident, string $lang)
    {
        $data = array('report' => $incident->getType()->getReport($lang), 'incident' => $incident, 'team' => $this->team);
        $this->getView()->setTemplate('CertUnlpNgenBundle:IncidentReport:Report/lang/mail.html.twig');
        $this->getView()->setTemplateData($data);
        $html = $this->viewHandler->renderTemplate($this->getView(), 'html');
        $parameters = array('incident' => $incident);

        return $this->templating->createTemplate($html)->render($parameters);
    }

    public function getView()
    {
        return $this->view;
    }

    public function getReportReply($incident, $body, $lang)
    {
        $data = array('report' => $incident->getType()->getReport($lang), 'incident' => $incident, 'body' => $body, 'team' => $this->team);
        $this->getView()->setTemplate('CertUnlpNgenBundle:IncidentReport:Report/lang/mailReply.html.twig');
        $this->getView()->setTemplateData($data);
        $html = $this->viewHandler->renderTemplate($this->getView(), 'html');
        $parameters = array('incident' => $incident);

        return $this->templating->createTemplate($html)->render($parameters);
    }

    public function getCustomHandler()
    {
        return $this->custom_handler;
    }

    /**
     * @param View $view
     *
     * @return Response
     */
    public function handle($view = null)
    {
        $view = $view ? $view : $this->view;
        return $this->viewHandler->handle($view);
    }

    /**
     * @param array $parameters
     * @param $statusCode
     * @param array $headers
     * @return View
     */
    public function response(array $parameters = array(), $statusCode = Response::HTTP_CREATED, array $headers = array())
    {
        $this->setData($parameters);
        $this->setStatusCode($statusCode);
        return $this->view;
    }

    /**
     * @param array $data
     * @return View
     */
    public function setData(array $data)
    {
        return $this->view->setData($data);
    }

    /**
     * @param $statusCode
     * @return View
     */
    public function setStatusCode($statusCode)
    {
        return $this->view->setStatusCode($statusCode);
    }

}
