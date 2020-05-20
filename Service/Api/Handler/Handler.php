<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\EntityApi;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class Handler
{
    /**
     * @var EntityManagerInterface
     */
    private $entity_manager;
    /**
     * @var ObjectRepository
     */
    private $repository;
    /**
     * @var AbstractType
     */
    private $entity_type;
    /**
     * @var FormFactoryInterface
     */
    private $form_factory;

    /**
     * Handler constructor.
     * @param EntityManagerInterface $entity_manager
     * @param ObjectRepository $repository
     * @param AbstractType $entity_type
     * @param FormFactoryInterface $form_factory
     */
    public function __construct(EntityManagerInterface $entity_manager, ObjectRepository $repository, AbstractType $entity_type, FormFactoryInterface $form_factory)
    {
        $this->entity_manager = $entity_manager;
        $this->repository = $repository;
        $this->form_factory = $form_factory;
        $this->entity_type = $entity_type;
    }


    /**
     * @param array $params
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return array|EntityApi[]
     */
    public function all(array $params = [], array $order = [], int $limit = 0, int $offset = 0): array
    {
        return $this->getRepository()->findBy($params, $order, $limit, $offset);
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->repository;
    }

    /**
     * @param array $parameters
     * @param bool $csrf_protection
     * @return EntityApi
     */
    public function post(array $parameters, bool $csrf_protection = false): EntityApi
    {
        $entity = $this->mergeIfExists($this->createEntityInstance($parameters));
        return $this->processForm($entity, $parameters, Request::METHOD_POST, $csrf_protection);
    }

    /**
     * @param EntityApi $entity
     * @return EntityApi
     */
    public function mergeIfExists(EntityApi $entity): EntityApi
    {
        if ($this->needCheckIfExists()) {
            $entity_db = $this->getIfExists($entity);
            if ($entity_db) {
                if ($this->isReactivableEntity()) {
                    $entity_db->activate();
                }
                if ($this->isMergeableEntity()) {
                    $entity_db = $this->mergeEntity($entity_db, $entity);
                }
                $entity = $entity_db;
            }
        }
        return $entity;
    }

    public function needCheckIfExists(): bool
    {
        return true;
    }

    /**
     * @param EntityApi $entity
     * @return EntityApi
     */
    public function getIfExists(EntityApi $entity): ?EntityApi
    {
        return $this->get($this->getEntityIdentificationArray($entity));
    }

    /**
     * @param array $parameters
     * @return EntityApi|object|null
     */
    public function get(array $parameters): ?EntityApi
    {
        return $this->getRepository()->findOneBy($parameters);
    }

    /**
     * @param EntityApi $entity
     * @return array
     */
    public function getEntityIdentificationArray(EntityApi $entity): array
    {
        return $entity->getEntityIdentificationArray();
    }

    public function isReactivableEntity(): bool
    {
        return true;

    }

    public function isMergeableEntity(): bool
    {
        return true;

    }

    /**
     * @param EntityApi $entity
     * @param EntityApi $entity_db
     * @return EntityApi
     */
    public function mergeEntity(EntityApi $entity_db, EntityApi $entity): EntityApi
    {
        return $entity_db;
    }

    /**
     * @param array $parameters
     * @return EntityApi
     */
    public function createEntityInstance(array $parameters = []): EntityApi
    {
        $class_name = $this->getRepository()->getClassName();
        return new $class_name($parameters);
    }

    /**
     * @param EntityApi $entity
     * @param array $parameters
     * @param string $method
     * @param bool $csrf_protection
     * @return EntityApi
     */
    public function processForm(EntityApi $entity, array $parameters = [], string $method = Request::METHOD_PUT, bool $csrf_protection = true): EntityApi
    {
        $form = $this->getFormFactory()->create($this->getEntityType(), $entity, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $parameters = $this->cleanParameters($parameters);
        $form->submit($parameters, Request::METHOD_PATCH !== $method);

        if ($form->isValid()) {
            $entity = $form->getData();
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return $entity;
        }
        throw new InvalidFormException
        ('Invalid submitted data', $form);
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory(): FormFactoryInterface
    {
        return $this->form_factory;
    }

    /**
     * @return AbstractType
     */
    public function getEntityType(): AbstractType
    {
        return $this->entity_type;
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function cleanParameters(array $parameters): array
    {
        return $parameters;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entity_manager;
    }

    /**
     * @param EntityApi $entity
     * @param array $parameters
     * @return EntityApi
     */
    public function put(EntityApi $entity, array $parameters = []): EntityApi
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PUT, false);
    }


    /**
     * @param EntityApi $entity
     * @param array $parameters
     * @return EntityApi
     */
    public function desactivate(EntityApi $entity, array $parameters = []): EntityApi
    {
        return $this->patch($entity->desactivate(), $parameters);
    }

    /**
     * @param EntityApi $entity
     * @param array|null $parameters
     * @return EntityApi
     */
    public function patch(EntityApi $entity, array $parameters = null): EntityApi
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PATCH, false);
    }

    /**
     * @param EntityApi $entity
     * @param array $parameters
     * @return EntityApi
     */
    public function delete(EntityApi $entity, array $parameters = []): EntityApi
    {
        return $this->patch($this->prepareToDeletion($entity), $parameters);
    }

    /**
     * @param EntityApi $entity
     * @return EntityApi
     */
    public function prepareToDeletion(EntityApi $entity): EntityApi
    {
        return $entity->desactivate();

    }

    /**
     * @param EntityApi $entity
     * @param array $parameters
     * @return EntityApi
     */
    public function activate(EntityApi $entity, array $parameters = []): EntityApi
    {
        return $this->patch($entity->activate(), $parameters);
    }

}
