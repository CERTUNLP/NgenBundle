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

class NetworkFrontendController extends FrontendController {

    public function homeEntity(Request $request, $entity = 'Network') {
        $em = $this->getDoctrine();
        $dql = "SELECT n,au,na "
                . "FROM CertUnlpNgenBundle:Network n join n.academic_unit au join n.network_admin na";
        $query = $em->createQuery($dql);

        $pagination = $this->getPaginator()->paginate(
                $query, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'n.createdAt', 'defaultSortDirection' => 'desc')
        );

        return array('objects' => $pagination);
    }

}
