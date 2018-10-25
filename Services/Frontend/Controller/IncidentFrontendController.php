<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Frontend\Controller;

use CertUnlp\NgenBundle\Model\IncidentInterface;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class IncidentFrontendController extends FrontendController
{

    private $evidence_path;

    public function __construct($doctrine, FormFactory $formFactory, $entityType, Paginator $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entityType, $paginator, $finder, $comment_manager, $thread_manager);
        $this->evidence_path = $evidence_path;
    }

    public function evidenceIncidentAction(IncidentInterface $incident)
    {

        $zipname = $incident . '_' . md5(time()) . '.zip';
        $zip = new \ZipArchive();
        $zip->open("/tmp/" . $zipname, \ZipArchive::CREATE);

        $evidence_path = $this->evidence_path . $incident->getEvidenceSubDirectory() . "/";

        $options = array('remove_all_path' => TRUE);
        $zip->addGlob($evidence_path . $incident . "*", GLOB_BRACE, $options);
        $zip->close();

        $response = new BinaryFileResponse("/tmp/" . $zipname);
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-disposition', ' attachment; filename="' . $zipname . '"');
        $response->headers->set('Content-Length', filesize("/tmp/" . $zipname));
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $zipname
        );

        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

}
