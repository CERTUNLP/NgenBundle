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
use Twig\Environment;
use Twig\Error\Error;

class IncidentReportFactory
{
    /**
     * @var Environment
     */
    private Environment $templating;
    /**
     * @var array
     */
    private array $team;
    /**
     * @var IncidentLangFactory
     */
    private IncidentLangFactory $incident_lang_factory;

    public function __construct(Environment $templating, array $ngen_team, IncidentLangFactory $incident_lang_factory)
    {
        $this->templating = $templating;
        $this->team = $ngen_team;
        $this->incident_lang_factory = $incident_lang_factory;
    }

    /**
     * @param Incident $incident
     * @return string
     */
    public function getReport(Incident $incident): ?string
    {
        $report = $incident->getType()->getReport($this->getIncidentLangFactory()->getLangByIncident($incident));
        if ($report) {
            $data = array('report' => $report, 'incident' => $incident, 'team' => $this->getTeam(), 'lang' => $this->getIncidentLangFactory()->getLangByIncident($incident));
            $parameters = array('incident' => $incident);
            try {
                return $this->getTemplating()->createTemplate($this->getTemplating()->render('CertUnlpNgenBundle:IncidentReport:Report/lang/mail.html.twig', $data))->render($parameters);
            } catch (Error $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @return IncidentLangFactory
     */
    public function getIncidentLangFactory(): IncidentLangFactory
    {
        return $this->incident_lang_factory;
    }

    /**
     * @return array
     */
    public function getTeam(): array
    {
        return $this->team;
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
     * @return string|null
     */
    public function getReportReply(Incident $incident, string $body): ?string
    {
        $report = $incident->getType()->getReport($this->getIncidentLangFactory()->getLangByIncident($incident));
        if ($report) {
            $data = array('report' => $report, 'incident' => $incident, 'body' => $body, 'team' => $this->getTeam(), 'lang' => $this->getLangByIncident($incident));
            $parameters = array('incident' => $incident);
            try {
                return $this->getTemplating()->createTemplate($this->getTemplating()->render('CertUnlpNgenBundle:IncidentReport:Report/lang/mailReply.html.twig', $data))->render($parameters);
            } catch (Error $e) {
                return null;
            }
        }
        return null;
    }
}
