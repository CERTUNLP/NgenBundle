<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use CertUnlp\NgenBundle\Model\IncidentInterface;

/**
 * Description of incidentEvidenceManager
 *
 * @author demyen
 */
class IncidentEvidenceManager {

    public function __construct($upload_directory) {
        $this->upload_directory = $upload_directory;
    }

    public function prePersistDelegation(IncidentInterface $incident) {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

    public function preUpdateDelegation(IncidentInterface $incident) {
        $this->setFilename($incident);
        $this->uploadEvidenceFile($incident);
    }

//    public function postPersistDelegation(IncidentInterface $incident) {
//        $this->uploadEvidenceFile($incident);
//    }
//
//    public function postUpdateDelegation(IncidentInterface $incident) {
//        $this->uploadEvidenceFile($incident);
//    }

    public function setFilename(IncidentInterface $incident) {
        if ($incident->getEvidenceFile()) {
            $ext = "_" . sha1(uniqid(mt_rand(), true));
            if (is_callable(array($incident->getEvidenceFile(), 'getClientOriginalExtension'))) {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getClientOriginalExtension());
            } else {

                $incident->setEvidenceFilePath($ext . "." . $incident->getEvidenceFile()->getExtension());
            }
        }
    }

    public function uploadEvidenceFile(IncidentInterface $incident) {

//        if (null === $incident->getEvidenceFile()) {
//            return;
//        }
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $uploadDir = $this->getUploadDirectory() . $incident->getEvidenceSubDirectory();
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                die('Failed to create folders...');
            }
        }

        $incident->getEvidenceFile()->move($uploadDir, $incident->getEvidenceFilePath());

        // check if we have an old image
//        if ($incident->getEvidenceFileTemp()) {
//            // delete the old image
//            unlink($this->getUploadDirectory() . $incident->getEvidenceFileTemp());
//            // clear the temp image path
//            $incident->setEvidenceFileTemp(null);
//        }
    }

    protected function getUploadDirectory() {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->upload_directory;
    }

}
