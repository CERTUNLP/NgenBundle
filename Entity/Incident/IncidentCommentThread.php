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
//     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Host\Host", inversedBy="comment_thread")
//     *
//     * */
//    protected $host;

    /**
     * Set id
     *
     * @param string $id
     * @return IncidentCommentThread
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get incident
     *
     * @return Incident
     */
    public function getIncident()
    {
        return $this->incident;
    }

    /**
     * Set incident
     *
     * @param Incident $incident
     * @return IncidentCommentThread
     */
    public function setIncident(Incident $incident = null)
    {
        $this->incident = $incident;

        return $this;
    }

}
