<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;

class IncidentReportFactory
{


    /**
     * @var Environment
     */
    private $templating;
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;
    /**
     * @var View
     */
    private $view;
    /**
     * @var array
     */
    private $team;

    public function __construct(Environment $templating, ViewHandlerInterface $viewHandler, array $ngen_team)
    {
        $this->templating = $templating;
        $this->viewHandler = $viewHandler;
        $this->team = $ngen_team;
    }

    /**
     * @param Incident $incident
     * @param string $lang
     * @return string
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function getReport(Incident $incident, string $lang): ?string
    {
        $report = $incident->getType()->getReport($lang);
        if ($report) {
            $data = array('report' => $report, 'incident' => $incident, 'team' => $this->getTeam());
            $this->getView()->setTemplate('CertUnlpNgenBundle:IncidentReport:Report/lang/mail.html.twig');
            $this->getView()->setTemplateData($data);
            $html = $this->getViewHandler()->renderTemplate($this->getView(), 'html');
            $parameters = array('incident' => $incident);
            return $this->getTemplating()->createTemplate($html)->render($parameters);
        }
        return null;
    }

    /**
     * @return array
     */
    public function getTeam(): array
    {
        return $this->team;
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        if (!$this->view) {
            $this->view = View::create();
        }
        return $this->view;
    }

    /**
     * @return ViewHandlerInterface
     */
    public function getViewHandler(): ViewHandlerInterface
    {
        return $this->viewHandler;
    }

    /**
     * @return Environment
     */
    public function getTemplating(): Environment
    {
        return $this->templating;
    }

    /**
     * @param Incident $incident
     * @param string $body
     * @param string $lang
     * @return string|null
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function getReportReply(Incident $incident, string $body, string $lang): ?string
    {
        $report = $incident->getType()->getReport($lang);
        if ($report) {

            $data = array('report' => $report, 'incident' => $incident, 'body' => $body, 'team' => $this->getTeam());
            $this->getView()->setTemplate('CertUnlpNgenBundle:IncidentReport:Report/lang/mailReply.html.twig');
            $this->getView()->setTemplateData($data);
            $html = $this->getViewHandler()->renderTemplate($this->getView(), 'html');
            $parameters = array('incident' => $incident);

            return $this->getTemplating()->createTemplate($html)->render($parameters);
        }
        return null;
    }

    /**
     * @param View|null $view
     * @return Response
     */
    public function handle(View $view = null): Response
    {
        $view = $view ?: $this->getView();
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @param array $parameters
     * @param $statusCode
     * @param array $headers
     * @return View
     */
    public function response(array $parameters = array(), int $statusCode = Response::HTTP_CREATED, array $headers = array()): View
    {
        $this->setData($parameters);
        $this->setStatusCode($statusCode);
        return $this->getView();
    }

    /**
     * @param array $data
     * @return View
     */
    public function setData(array $data): View
    {
        return $this->getView()->setData($data);
    }

    /**
     * @param $statusCode
     * @return View
     */
    public function setStatusCode(int $statusCode): View
    {
        return $this->getView()->setStatusCode($statusCode);
    }

}
