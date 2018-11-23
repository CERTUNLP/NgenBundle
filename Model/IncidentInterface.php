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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\Network\NetworkAdmin;
use DateTime;
use FOS\CommentBundle\Model\Thread;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author demyen
 */
interface IncidentInterface
{

    /**
     * get id
     *
     * @return int|string
     */
    public function getId();

    /**
     * Set hostAddress
     *
     * @param IncidentFeed $feed
     * @return Incident
     */
    public function setFeed(IncidentFeed $feed);

    /**
     * Get $state
     *
     * @return IncidentFeed
     */
    public function getFeed();

    /**
     * Set IncidentDecision
     *
     * @param $state
     * @return Incident
     */
    public function setState(IncidentState $state);

    /**
     * Get $state
     *
     * @return IncidentState
     */
    public function getState();

    /**
     * Set hostAddress
     *
     * @param string $hostAddress
     * @return Incident
     */
    public function setHostAddress($hostAddress);

    /**
     * Get hostAddress
     *
     * @return string
     */
    public function getHostAddress();

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return Incident
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
    public function isClosed();

    /**
     * Get isClosed
     *
     * @return boolean
     */
    public function close();

    /**
     * Set network
     *
     * @param NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null);

    /**
     * Get network
     *
     * @return NetworkInterface
     */
    public function getNetwork();

    /**
     * Set type
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident\IncidentType $type
     * @return Incident
     */
    public function setType(\CertUnlp\NgenBundle\Entity\Incident\IncidentType $type = null);

    /**
     * Get type
     *
     * @return \CertUnlp\NgenBundle\Entity\Incident\IncidentType
     */
    public function getType();

    /**
     * Set date
     *
     * @param DateTime $date
     * @return Incident
     */
    public function setDate(DateTime $date);

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
     * @return Incident
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
     * @param File $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null);

    /**
     * Get evidence_file
     *
     * @return UploadedFile
     */
    public function getEvidenceFile();

    /**
     * Set evidence_file_path
     *
     * @param string $evidenceFilePath
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidenceFilePath);

    /**
     * Get evidence_file_path
     *
     * @param string $fullPath
     * @return string
     */
    public function getEvidenceFilePath(string $fullPath = '');

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
     * @return Incident
     */
    public function setEvidenceFileTemp(string $evidenceFileTemp);

    /**
     * Get evidence_file_temp
     *
     * @return string
     */
    public function getEvidenceFileTemp();

    /**
     * Get an array with emails
     *
     * @return array
     */
    public function getEmails();

    /**
     * Set report_sent
     *
     * @param boolean $sendReport
     * @return Incident
     */
    public function setSendReport(bool $sendReport);

    /**
     * Get sendReport
     *
     * @return boolean
     */
    public function getSendReport();

    /**
     * @return string
     */
    public function getReportMessageId();

    /**
     * @param string $reportMessageId
     * @return string
     */
    public function setReportMessageId(string $reportMessageId);

    /**
     * @param string $slug
     * @return mixed
     */
    public function setSlug(string $slug);

    /**
     * @param NetworkAdmin $networkAdmin
     * @return mixed
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin);

    /**
     * @param Thread $thread
     * @return mixed
     */
    public function setCommentThread(Thread $thread);

    /**
     * @return NetworkAdmin
     */
    public function getNetworkAdmin();

}
