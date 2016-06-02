<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author demyen
 */
interface IncidentInterface {

    /**
     * Set hostAddress
     *
     * @param string $hostAddress
     * @return InternalIncident
     */
    public function setHostAddress($hostAddress);

    /**
     * Get hostAddress
     *
     * @return string 
     */
    public function getHostAddress();

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return InternalIncident
     */
//    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
//    public function getCreatedAt();

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return InternalIncident
     */
//    public function setUpdatedAt($updatedAt);

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
//    public function getUpdatedAt();

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return InternalIncident
     */
    public function setIsClosed($isClosed);

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function getIsClosed();

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function close();

    /**
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return InternalIncident
     */
    public function setNetwork(\CertUnlp\NgenBundle\Model\NetworkInterface $network = null);

    /**
     * Get network
     *
     * @return \CertUnlp\NgenBundle\Model\NetworkInterface
     */
    public function getNetwork();

    /**
     * Set type
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentType $type
     * @return InternalIncident
     */
    public function setType(\CertUnlp\NgenBundle\Entity\IncidentType $type = null);

    /**
     * Get type
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentType 
     */
    public function getType();

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return InternalIncident
     */
    public function setDate($date);

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate();

    public function __toString();

    /**
     * Set reporter
     *
     * @param \CertUnlp\NgenBundle\Model\ReporterInterface $reporter
     * @return InternalIncident
     */
    public function setReporter(ReporterInterface $reporter = null);

    /**
     * Get reporter
     *
     * @return \CertUnlp\NgenBundle\Model\ReporterInterface 
     */
    public function getReporter();

    /**
     * Set evidence_file
     *
     * @param string $evidenceFile
     * @return InternalIncident
     */
    public function setEvidenceFile(File $evidenceFile = null);

    /**
     * Get evidence_file
     *
     * @return string 
     */
    public function getEvidenceFile();

    /**
     * Set evidence_file_path
     *
     * @param string $evidenceFilePath
     * @return InternalIncident
     */
    public function setEvidenceFilePath($evidenceFilePath);

    /**
     * Get evidence_file_path
     *
     * @return string 
     */
    public function getEvidenceFilePath();

    /**
     * Get evidence sub directory
     *
     * @return string 
     */
    public function getEvidenceSubDirectory();

    /**
     * Set evidence_file_temp
     *
     * @param string $evidenceFileTemp
     * @return InternalIncident
     */
    public function setEvidenceFileTemp($evidenceFileTemp);

    /**
     * Get evidence_file_temp
     *
     * @return string 
     */
    public function getEvidenceFileTemp();

    /**
     * Set report_sent
     *
     * @param boolean $sendReport
     * @return InternalIncident
     */
    public function setSendReport($sendReport);

    /**
     * Get sendReport
     *
     * @return boolean 
     */
    public function getSendReport();
}
