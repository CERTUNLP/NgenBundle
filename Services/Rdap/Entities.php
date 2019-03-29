<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

/**
 * Description of Entities
 *
 * @author dam
 */
class Entities
{
    /**
     * @var Entity[] | array
     */
    private $entities;

    /**
     * Entities constructor.
     * @param array $entities
     */
    public function __construct(array $entities = [])
    {
        $this->entities = [];
        foreach ($entities as $entity) {

            $this->entities[] = new Entity($entity);
        }
    }

    /**
     * @param $roles array
     * @return Entity|mixed|null
     */
    public function getOneByRole(array $roles): Entity
    {
        $entities = $this->getByRole($roles);

        if ($entities) {
            return $entities[0];
        }

        return null;
    }

    /**
     * @param array $roles
     * @return Entity[]|array
     */
    public function getByRole(array $roles): array
    {
        $entities = [];
        foreach ($this->getEntities() as $entity) {
            foreach ($roles as $role) {

                if (\in_array($role, $entity->getRoles(), true)) {
                    $entities[] = $entity;
                } else if (strpos($entity->getRolesAsString(), $role) !== false) {
                    $entities[] = $entity;
                }
            }
        }

        return $entities;
    }

    /**
     * @param \Closure|null $callback
     * @return Entity[] | array
     */
    public function getEntities(\Closure $callback = null): array
    {
        $entities = [[]];
        foreach ($this->entities as $entity) {
            $entities[] = $entity->getEntities($callback);
        }
        $entities = array_merge(...$entities);

        return $entities;
    }

    /**
     * @return Entity| null
     */
    public function getAbuseEntity(): ?Entity
    {
        $abuse_entities = $this->getAbuseEntities();
        return $abuse_entities ? $abuse_entities[0] : null;
    }

    /**
     * @return Entity[]|array
     */
    public function getAbuseEntities(): array
    {

        $abuse_entities = $this->getByRole(['abuse']);
        $extra_entities = $this->getByRole(['noc', 'technical']);
        return $abuse_entities ?: $extra_entities;
    }

    /**
     * @return array
     */
    public function getAbuseEmails(): array
    {
        $abuse_emails = [[]];
        $abuse_entities = $this->getAbuseEntities();

        foreach ($abuse_entities as $abuse_entity) {
            $abuse_emails[] = $abuse_entity->getEmails();
        }
        $abuse_emails = array_merge(...$abuse_emails);

        return $abuse_emails;
    }

}
