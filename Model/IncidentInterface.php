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
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
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
 * @author drubio
 */
interface IncidentInterface
{

    /**
     * get id
     *
     * @return int|string
     */
    public function getId(): ?int;

    /**
     * Set ip
     *
     * @param IncidentFeed $feed
     * @return Incident
     */
    public function setFeed(IncidentFeed $feed): Incident;

    /**
     * Get $state
     *
     * @return IncidentFeed
     */
    public function getFeed(): ?IncidentFeed;

    /**
     * Set IncidentDecision
     *
     * @param $state
     * @return Incident
     */
    public function setState(IncidentState $state): Incident;

    /**
     * Get $state
     *
     * @return IncidentState
     */
    public function getState(): ?IncidentState;

    /**
     * Set ip
     *
     * @param string $ip
     * @return Incident
     */
    public function setIp(string $ip): Incident;

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp(): ?string;

    /**
     * Set isClosed
     *
     * @param bool $isClosed
     * @return Incident
     */
    public function setIsClosed(bool $isClosed): Incident;

    /**
     * Get isClosed
     *
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * Get isClosed
     *
     * @return Incident
     */
    public function close(): Incident;

    /**
     * Get isClosed
     *
     * @return Incident
     */
    public function open(): Incident;

    /**
     * Set network
     *
     * @param NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null): Incident;

    /**
     * Get network
     *
     * @return NetworkInterface
     */
    public function getNetwork(): ?NetworkInterface;

    /**
     * Set type
     *
     * @param IncidentType $type
     * @return Incident
     */
    public function setType(IncidentType $type = null): Incident;

    /**
     * Get type
     *
     * @return IncidentType
     */
    public function getType(): ?IncidentType;

    /**
     * Set date
     *
     * @param DateTime $date
     * @return Incident
     */
    public function setDate(DateTime $date): Incident;

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate(): ?\DateTime;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * Set reporter
     *
     * @param ReporterInterface $reporter
     * @return Incident
     */
    public function setReporter(ReporterInterface $reporter = null): Incident;

    /**
     * Get reporter
     *
     * @return ReporterInterface
     */
    public function getReporter(): ?ReporterInterface;

    /**
     * Set evidence_file
     *
     * @param File $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null): Incident;

    /**
     * Get evidence_file
     *
     * @return UploadedFile
     */
    public function getEvidenceFile(): ?UploadedFile;

    /**
     * Set evidence_file_path
     *
     * @param string $evidenceFilePath
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidenceFilePath): Incident;

    /**
     * Get evidence_file_path
     *
     * @param string $fullPath
     * @return string
     */
    public function getEvidenceFilePath(string $fullPath = ''): string;

    /**
     * Get evidence sub directory
     *
     * @return string
     */
    public function getEvidenceSubDirectory(): string;

    /**
     * Set evidence_file_temp
     *
     * @param string $evidenceFileTemp
     * @return Incident
     */
    public function setEvidenceFileTemp(string $evidenceFileTemp): Incident;

    /**
     * Get evidence_file_temp
     *
     * @return string
     */
    public function getEvidenceFileTemp(): string;

    /**
     * Get an array with emails
     *
     * @return array
     */
    public function getEmails(): array;

    /**
     * Set report_sent
     *
     * @param boolean $sendReport
     * @return Incident
     */
    public function setSendReport(bool $sendReport): Incident;

    /**
     * Get sendReport
     *
     * @return bool
     */
    public function isSendReport(): bool;

    /**
     * @return string
     */
    public function getReportMessageId(): string;

    /**
     * @param string $reportMessageId
     * @return Incident
     */
    public function setReportMessageId(string $reportMessageId): Incident;

    /**
     * @param string $slug
     * @return Incident
     */
    public function setSlug(string $slug): Incident;

    /**
     * @param Thread $thread
     * @return Incident
     */
    public function setCommentThread(Thread $thread): Incident;

//    /**
//     * @param NetworkAdmin $networkAdmin
//     * @return Incident
//     */
//    public function setNetworkAdmin(NetworkAdmin $networkAdmin): Incident;
//
//
//    /**
//     * @return NetworkAdmin
//     */
//    public function getNetworkAdmin(): NetworkAdmin;
//
//    /**
//     * @return NetworkEntity
//     */
//    public function getNetworkEntity(): NetworkEntity;
//
//    /**
//     * @param NetworkEntity $networkEntity
//     * @return Incident
//     */
//    public function setNetworkEntity(NetworkEntity $networkEntity): Incident;

}
