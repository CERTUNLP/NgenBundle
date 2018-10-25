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
use CertUnlp\NgenBundle\Model\ReporterInterface;
use Gedmo\Sluggable\Util as Sluggable;
use Redmine\Client;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class IncidentRedmine implements ContainerAwareInterface
{

    private $client;
    private $project_id = "cert";
    private $tracker_name = "Incidentes";

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;
    private $evidence_directory;

    function __construct($redmine_url, $redmine_key, $evidence_directory, ContainerInterface $container)
    {
        $this->client = new Client($redmine_url, $redmine_key);
        $this->evidence_directory = $evidence_directory;
        $this->setContainer($container);
    }


    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function addUsers($users)
    {
        foreach ($users as $reporter) {
            $this->createUser($reporter);
        }
    }

    public function createUser(ReporterInterface $reporter)
    {
        $this->getClient()->api('user')->create(array(
            'login' => $reporter->getUsername(),
            'firstname' => $reporter->getName(),
            'lastname' => $reporter->getLastname(),
            'mail' => $reporter->getEmail(),
        ));
    }

    public function getClient()
    {
        return $this->client;
    }

    public function createProject($name)
    {
        $this->getClient()->api('project')->create(array(
            'name' => $name,
            'identifier' => Sluggable\Urlizer::urlize($name, '_'),
            'tracker_ids' => array(),
        ));
    }

    public function addIssueCategory($category_name)
    {
        $this->getClient()->api('issue_category')->create($this->project_id, array(
            'name' => $category_name,
        ));
    }

    public function addIssueCategories($category_names)
    {
        foreach ($category_names as $category_name) {
            $this->getClient()->api('issue_category')->create('cert', array(
                'name' => $category_name,
            ));
        }
    }

    public function prePersistDelegation(IncidentInterface $incident)
    {
        if (!in_array($this->container->get('kernel')->getEnvironment(), array('test', 'dev'))) {
            $this->addIssue($incident);
        }
    }

    public function addIssue(IncidentInterface $incident)
    {


        $this->getClient()->setImpersonateUser($incident->getReporter()->getUsername());
        $this->createIssue($incident);
        $this->addTimeEntry($incident);
        $this->getClient()->setImpersonateUser(null);
    }

    public function createIssue(IncidentInterface $incident)
    {
        $description = 'Se nos informó que el host %s fue detectado en un incidente del tipo "%s".';
        $uploadFile = array();
        if (file_exists($this->evidence_directory . $incident->getEvidenceFilePath(true))) {
            $upload = json_decode($this->getClient()->api('attachment')->upload(file_get_contents($this->evidence_directory . $incident->getEvidenceFilePath(true))));
            $uploadFile = array(
                array(
                    'token' => $upload->upload->token,
                    'filename' => $incident->getEvidenceFilePath(),
                    'description' => 'Evidence file: ' . $incident->getEvidenceFilePath(),
                    'content_type' => mime_content_type($this->evidence_directory . $incident->getEvidenceFilePath(true)),
                ));
        }
        $issue = $this->getClient()->api('issue')->create(array(
            'project_id' => $this->project_id,
            'subject' => sprintf('Host %s en incidente "%s"', $incident->getHostAddress(), $incident->getType()),
            'description' => sprintf($description, $incident->getHostAddress(), $incident->getType()),
            'category_id' => $this->getClient()->api('issue_category')->getIdByName($this->project_id, $incident->getType()->getName()),
            'tracker_id' => $this->getClient()->api('tracker')->getIdByName($this->tracker_name),
            'watcher_user_ids' => $this->getClient()->api('user')->getIdByUsername('cert'),
            'uploads' => $uploadFile
        ));
        $incident->setRedmineIssue($issue);

        return $issue;
    }

    public function addTimeEntry(IncidentInterface $incident)
    {
        $this->getClient()->api('time_entry')->create(array(
//            'project_id' => $this->project_id,
            'issue_id' => $incident->getRedmineIssueId(),
            // 'spent_on' => null,
            'hours' => 0.33,
//            'activity_id' => 9,
            'comments' => sprintf('Incidente creado por %s', $incident->getReporter()->getUsername()),
        ));
    }

    public function postUpdateDelegation(IncidentInterface $incident)
    {
        if (!in_array($this->container->get('kernel')->getEnvironment(), array('test', 'dev'))) {
            $this->updateIssue($incident);
        }
    }

    public function updateIssue(IncidentInterface $incident)
    {

        $this->getClient()->setImpersonateUser($incident->getReporter()->getUsername());
        $this->getClient()->api('issue')->setIssueStatus($incident->getRedmineIssueId(), $incident->getState()->getName());
        $this->getClient()->setImpersonateUser(null);
    }

}
