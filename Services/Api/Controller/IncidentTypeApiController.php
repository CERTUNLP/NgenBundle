<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Services\Api\Controller\ApiController;

class IncidentTypeApiController extends ApiController {

    public function __construct($handler, $viewHandler, $view, $markdown_path) {
        parent::__construct($handler, $viewHandler, $view);
        $this->markdown_path = $markdown_path;
    }

    /**
     * Create a Object from the submitted data.
     *
     * @param $params array
     *
     * @return Network entity
     */
    public function findObjectBy($params) {
        return $this->getCustomHandler()->get(['name' => $params['name']]);
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param int     $id      the object id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when object not exist
     */
    public function patch(Request $request, $object, $reactivate = false) {
//        var_dump($request->request->get('reportEdit'));
//        $this->writeReportFile($object, $request->request->get('reportEdit'));
        
        return parent::patch($request, $object, $reactivate);
    }

    private function getReportName($incidentType) {
        return $this->markdown_path . "/" . $incidentType->getReportName();
    }

    private function writeReportFile($incidentType, $data) {
//        $data = str_replace('<br />', '\n', $data);
        return file_put_contents($this->getReportName($incidentType), $data);
    }

}
