<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use Doctrine\ORM\Mapping as ORM;


class IncidentDetectedListener
{
    /**
     * @var string
     */
    private $evidence_path;

    public function __construct(string $evidence_path)
    {
        $this->evidence_path = $evidence_path;
    }

    /** @ORM\PrePersist
     * @param IncidentDetected $incidentDetected
     */
    public function prePersistHandler(IncidentDetected $incidentDetected): void
    {
        $this->setFilename($incidentDetected);
        $this->uploadEvidenceFile($incidentDetected);
    }

    /**
     * @param IncidentDetected $incidentDetected
     */
    public function setFilename(IncidentDetected $incidentDetected): void
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

    /**
     * @param IncidentDetected $incidentDetected
     */
    public function uploadEvidenceFile(IncidentDetected $incidentDetected): void
    {
        $uploadDir = $this->getUploadDirectory() . $incidentDetected->getIncident()->getEvidenceSubDirectory();
        if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            die('Failed to create folders...');
        }

        if ($incidentDetected->getEvidenceFile()) {
            $incidentDetected->getEvidenceFile()->move($uploadDir, $incidentDetected->getEvidenceFilePath());
        }
    }

    /**
     * @return string
     */
    private function getUploadDirectory(): string
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->evidence_path;
    }

    /**
     * @ORM\PreUpdate
     * @param IncidentDetected $incidentDetected
     */
    public function preUpdateHandler(IncidentDetected $incidentDetected): void
    {
        $this->setFilename($incidentDetected);
        $this->uploadEvidenceFile($incidentDetected);
    }

}

