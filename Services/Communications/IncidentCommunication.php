<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Communications;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CommentBundle\Model\CommentManagerInterface;
use Symfony\Component\Translation\Translator;

abstract class IncidentCommunication
{

    protected $mailer;
    protected $cert_email;
    protected $upload_directory;
    protected $commentManager;
    protected $environment;
    protected $report_factory;
    protected $lang;
    protected $team;
    protected $translator;
    protected $doctrine;

    public function __construct(EntityManagerInterface $doctrine, CommentManagerInterface $commentManager, string $environment, string $lang, array $team, Translator $translator)
    {
        $this->doctrine = $doctrine;
        $this->commentManager = $commentManager;
        $this->environment = in_array($environment, ['dev', 'test']) ? '[dev]' : '';
        $this->lang = $lang;
        $this->team = $team;
        $this->translator = $translator;
    }

    public function postPersistDelegation($incident)
    {
        $this->comunicate($incident);
    }

    abstract public function comunicate(Incident $incident): void;


    /**
     * @return EntityManagerInterface
     */
    public function getDoctrine(): EntityManagerInterface
    {
        return $this->doctrine;
    }

}
