<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class IncidentCommentThread extends BaseThread
{

    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var Incident
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="comment_thread")
     *
     * */
    protected $incident;

//    /**
//     * @var Incident
//     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host", inversedBy="comment_thread")
//     *
//     * */
//    protected $host;

    /**
     * Set id
     *
     * @param string $id
     * @return IncidentCommentThread
     */
    public function setId($id): IncidentCommentThread
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Incident
     */
    public function getIncident(): Incident
    {
        return $this->incident;
    }

    /**
     * @param Incident $incident
     * @return IncidentCommentThread
     */
    public function setIncident(Incident $incident = null): IncidentCommentThread
    {
        $this->incident = $incident;

        return $this;
    }

}
