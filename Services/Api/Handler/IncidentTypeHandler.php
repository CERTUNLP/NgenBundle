<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Services\Api\Handler\Handler;

class IncidentTypeHandler extends Handler {

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $incident_type
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function prepareToDeletion($incident_type, array $parameters = null) {
        $incident_type->setIsActive(FALSE);
    }

    protected function checkIfExists($incident_type, $method) {
        $incident_typeDB = $this->repository->findOneBy(['slug' => $incident_type->getSlug()]);

        if ($incident_typeDB && $method == 'POST') {
            if (!$incident_typeDB->getIsActive()) {
                $incident_typeDB->setIsActive(TRUE);
            }
            $incident_type = $incident_typeDB;
        }
        return $incident_type;
    }

}
