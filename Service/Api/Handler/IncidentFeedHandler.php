<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;

class IncidentFeedHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param IncidentFeed $incident_feed
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($incident_feed, array $parameters = null)
    {
        $incident_feed->setIsActive(FALSE);
    }

    protected function checkIfExists($incident_feed, $method)
    {
        $incident_feedDB = $this->repository->findOneBy(['slug' => $incident_feed->getSlug()]);

        if ($incident_feedDB && $method === 'POST') {
            if (!$incident_feedDB->getIsActive()) {
                $incident_feedDB->setIsActive(TRUE);
            }
            $incident_feed = $incident_feedDB;
        }
        return $incident_feed;
    }

}
