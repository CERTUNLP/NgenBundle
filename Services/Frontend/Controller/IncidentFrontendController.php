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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class IncidentFrontendController extends FrontendController
{

    private $evidence_path;
    private $userLogged;

    public function __construct($doctrine, FormFactory $formFactory, $entityType, Paginator $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, $securityContext, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entityType, $paginator, $finder, $comment_manager, $thread_manager);
        $this->evidence_path = $evidence_path;
        $this->userLogged = $securityContext->getToken()->getUser();
    }

    public function evidenceIncidentAction(Incident $incident)
    {

        $zipname = $incident . '.zip';
        $zip = new \ZipArchive();
        $evidence_path = $this->evidence_path . $incident->getEvidenceSubDirectory() . "/";
        $zip->open($evidence_path . $zipname, \ZipArchive::CREATE);


        $options = array('remove_all_path' => TRUE);
        $zip->addGlob($evidence_path . $incident . "*", GLOB_BRACE, $options);
        $zip->close();

        $response = new BinaryFileResponse($evidence_path . $zipname);
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-disposition', ' attachment; filename="' . $zipname . '"');
        $response->headers->set('Content-Length', filesize($evidence_path . $zipname));
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $zipname
        );

        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

    public function newEntity(Request $request)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->getDoctrine(), $this->userLogged->getId()))->createView(), 'method' => 'POST');
    }

    public function editEntity($object)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->getDoctrine(), $this->userLogged->getId()), $object)->createView(), 'method' => 'patch');
    }

    public function homeEntity(Request $request, $term = '', $limit = 7, $defaultSortFieldName='createdAt',$defaultSortDirection='desc')
    {
        if (!$term) {
            $term = $request->get('term') ? $request->get('term') : '*';
        }

        $match = new \Elastica\Query\QueryString();
        $match->setQuery($term);

        $term3 = new \Elastica\Query\BoolQuery();
        $term2 = new \Elastica\Query\BoolQuery();

        $assigned_term=new \Elastica\Query\Match("assigned.id",$this->userLogged->getId());
        $term2->addMust($match);
        $term2->addMust($assigned_term);


        $unasiggned_term = new \Elastica\Query\BoolQuery();
        $existQuery = new \Elastica\Query\Exists('assigned.id');
        $open=new \Elastica\Query\Match("isClosed",'0');
        $unasiggned_term->addMustNot($existQuery);
        $term3->addMust($match);
        $term3->addMust($open);
        $term3->addMust($unasiggned_term);


        return array('objects'=>$this->searchEntity($request, $term, $limit,$defaultSortFieldName,$defaultSortDirection,'pageobject','object')['objects'],'my_objects'=>$this->searchEntity($request, $term2, $limit,$defaultSortFieldName,$defaultSortDirection,'pagemy','my')['objects'],'unassigned_objects'=>$this->searchEntity($request, $term3, $limit,$defaultSortFieldName,$defaultSortDirection,'pageunassigned','unassigned')['objects'],'term'=> $term);

    }
}
