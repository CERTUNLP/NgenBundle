<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\Listener;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;


class IncidentDetectedListener
{

    private $upload_directory;

    public function __construct($upload_directory)
    {
        $this->upload_directory = $upload_directory;
    }

    /** @ORM\PrePersist
     * @param IncidentDetected $incident
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(IncidentDetected $incident,LifecycleEventArgs $event)
    {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

    public function setFilename(IncidentDetected $incident)
    {
        if ($incident->getEvidenceFile()) {
            $ext = $incident->getIncident()->getEvidenceSubDirectory()."/_" . sha1(uniqid(mt_rand(), true));
            if (is_callable(array($incident->getEvidenceFile(), 'getClientOriginalExtension'))) {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getClientOriginalExtension());
            } else {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getExtension());
            }
        }
    }

    public function uploadEvidenceFile(IncidentDetected $incident)
    {
        $uploadDir = $this->getUploadDirectory() . $incident->getIncident()->getEvidenceSubDirectory();
        if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            die('Failed to create folders...');
        }

        if ($incident->getEvidenceFile()) {
            $incident->getEvidenceFile()->move($uploadDir, $incident->getEvidenceFilePath());
        }
    }

    protected function getUploadDirectory()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->upload_directory;
    }
    /** @ORM\PreUpdate
     * @param IncidentDetected $incident
     * @param PreUpdateEventArgs $event
     */

    public function preUpdateHandler(IncidentDetected $incident, PreUpdateEventArgs $event): void
    {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

}

