<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service;

use CertUnlp\NgenBundle\Entity\Incident\Incident;

/**
 * Description of incidentEvidenceManager
 *
 * @author demyen
 */
class IncidentEvidenceManager
{

    private $upload_directory;

    public function __construct($upload_directory)
    {
        $this->upload_directory = $upload_directory;
    }

    public function prePersistDelegation(Incident $incident)
    {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

    public function setFilename(Incident $incident)
    {
        if ($incident->getEvidenceFile()) {
            $ext = "_" . sha1(uniqid(mt_rand(), true));
            if (is_callable(array($incident->getEvidenceFile(), 'getClientOriginalExtension'))) {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getClientOriginalExtension());
            } else {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getExtension());
            }
        }
    }

//    public function postPersistDelegation(Incident $incident) {
//        $this->uploadEvidenceFile($incident);
//    }
//
//    public function postUpdateDelegation(Incident $incident) {
//        $this->uploadEvidenceFile($incident);
//    }

    public function uploadEvidenceFile(Incident $incident)
    {

//        if (null === $incident->getEvidenceFile()) {
//            return;
//        }
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $uploadDir = $this->getUploadDirectory() . $incident->getIncident()->getEvidenceSubDirectory();
        if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            die('Failed to create folders...');
        }

        if ($incident->getEvidenceFile()) {
            $incident->getEvidenceFile()->move($uploadDir, $incident->getEvidenceFilePath());
        }
        // check if we have an old image
//        if ($incident->getEvidenceFileTemp()) {
//            // delete the old image
//            unlink($this->getUploadDirectory() . $incident->getEvidenceFileTemp());
//            // clear the temp image path
//            $incident->setEvidenceFileTemp(null);
//        }
    }

    protected function getUploadDirectory()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->upload_directory;
    }

    public function preUpdateDelegation(Incident $incident)
    {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

}
