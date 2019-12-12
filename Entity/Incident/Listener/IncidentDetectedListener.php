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

    public function __construct(string $upload_directory)
    {
        $this->upload_directory = $upload_directory;
    }

    /** @ORM\PrePersist
     * @param IncidentDetected $incidentDetected
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(IncidentDetected $incidentDetected, LifecycleEventArgs $event)
    {
        $this->setFilename($incidentDetected);
        $this->uploadEvidenceFile($incidentDetected);
    }

    public function setFilename(IncidentDetected $incidentDetected)
    {
        if ($incidentDetected->getEvidenceFile()) {
            $ext = $incidentDetected->getIncident()->getEvidenceSubDirectory() . '/_' . sha1(uniqid(mt_rand(), true));
            if (is_callable(array($incidentDetected->getEvidenceFile(), 'getClientOriginalExtension'))) {

                $incidentDetected->setEvidenceFilePath($ext . '.' . $incidentDetected->getEvidenceFile()->getClientOriginalExtension());
            } else {
                $incidentDetected->setEvidenceFilePath($ext . '.' . $incidentDetected->getEvidenceFile()->getExtension());
            }
        }
    }

    public function uploadEvidenceFile(IncidentDetected $incidentDetected)
    {
        $uploadDir = $this->getUploadDirectory() . $incidentDetected->getIncident()->getEvidenceSubDirectory();
        if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            die('Failed to create folders...');
        }

        if ($incidentDetected->getEvidenceFile()) {
            $incidentDetected->getEvidenceFile()->move($uploadDir, $incidentDetected->getEvidenceFilePath());
        }
    }

    protected function getUploadDirectory()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->upload_directory;
    }

    /** @ORM\PreUpdate
     * @param IncidentDetected $incidentDetected
     * @param PreUpdateEventArgs $event
     */

    public function preUpdateHandler(IncidentDetected $incidentDetected, PreUpdateEventArgs $event): void
    {
        $this->setFilename($incidentDetected);
        $this->uploadEvidenceFile($incidentDetected);
    }

}

