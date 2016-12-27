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

use Symfony\Component\HttpFoundation\Request;
use CertUnlp\NgenBundle\Services\Frontend\Controller\FrontendController;

class IncidentFrontendController extends FrontendController {

    public function homeEntity(Request $request, $entity) {
        $em = $this->getDoctrine();
        $dql = "SELECT i,s,f,t "
                . "FROM CertUnlpNgenBundle:$entity i join i.state s inner join i.feed f join i.type t "
//                . "WHERE s.slug = 'open' and i.isClosed = false"
        ;
        $query = $em->createQuery($dql);

        $pagination = $this->getPaginator()->paginate(
                $query, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );

        return array('objects' => $pagination);
    }

}
