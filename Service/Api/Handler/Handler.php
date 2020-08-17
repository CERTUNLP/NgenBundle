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

use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
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
     * @param array|null $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array|EntityApiInterface[]
     */
    public function all(array $params = [], array $order = null, int $limit = null, int $offset = null): array
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
     * @return EntityApiInterface
     */
    public function post(array $parameters, bool $csrf_protection = false): EntityApiInterface
    {
        return $this->processForm($this->createEntityInstance($parameters), $parameters, Request::METHOD_POST, $csrf_protection);
    }

    /**
     * @param EntityApiInterface $entity
     * @param array $parameters
     * @param string $method
     * @param bool $csrf_protection
     * @return EntityApiInterface
     * @throws InvalidFormException
     */
    public function processForm(EntityApiInterface $entity, array $parameters = [], string $method = '', bool $csrf_protection = true)
    {
        $this->preProcessForm($entity);
        $form = $this->getFormFactory()->create($this->getEntityTypeClass(), $entity, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $parameters = $this->cleanParameters($parameters);
        $form->submit($parameters, Request::METHOD_PATCH !== $method);
        if ($form->isValid()) {
            $this->postValidationForm($entity);
            if ($method === Request::METHOD_POST) {
                $entity = $this->mergeIfExists($entity);
            }
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            $this->postProcessForm($entity);
            return $entity;
        }
        throw new InvalidFormException
        ('Invalid submitted data', $form);
    }

    /**
     * @param EntityApiInterface $entity_api
     * @return EntityApiInterface
     */
    public function preProcessForm(EntityApiInterface $entity_api): EntityApiInterface
    {
        return $entity_api;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory(): FormFactoryInterface
    {
        return $this->form_factory;
    }

    /**
     * @return string
     */
    public function getEntityTypeClass(): string
    {
        return get_class($this->entity_type);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function cleanParameters(array $parameters): array
    {
        unset($parameters['_method']);
        return $parameters;
    }

    /**
     * @param EntityApiInterface $entity_api
     * @return EntityApiInterface
     */
    public function postValidationForm(EntityApiInterface $entity_api): EntityApiInterface
    {
        return $entity_api;
    }

    /**
     * @param EntityApiInterface $entity
     * @return EntityApiInterface
     */
    public function mergeIfExists(EntityApiInterface $entity): EntityApiInterface
    {
        if ($this->needCheckIfExists()) {
            $entity_db = $this->getByDataIdentification($entity);
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
     * @param EntityApiInterface $entity
     * @return EntityApiInterface
     */
    public function getByDataIdentification(EntityApiInterface $entity): ?EntityApiInterface
    {
        return $this->get($entity->getDataIdentificationArray());
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|object|null
     */
    public function get(array $parameters): ?EntityApiInterface
    {
        return $this->getRepository()->findOneBy($parameters);
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
     * @param EntityApiInterface $entity
     * @param EntityApiInterface $entity_db
     * @return EntityApiInterface
     */
    public function mergeEntity(EntityApiInterface $entity_db, EntityApiInterface $entity): EntityApiInterface
    {
        return $entity_db;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entity_manager;
    }

    /**
     * @param EntityApiInterface $entity_api
     * @return EntityApiInterface
     */
    public function postProcessForm(EntityApiInterface $entity_api): EntityApiInterface
    {
        return $entity_api;
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
    {
        $class_name = $this->getRepository()->getClassName();
        return new $class_name($parameters);
    }

    /**
     * @param EntityApiInterface $entity
     * @return EntityApiInterface
     */
    public function getByIdentification(EntityApiInterface $entity): ?EntityApiInterface
    {
        return $this->get($entity->getIdentificationArray());
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
     * @return EntityApiInterface
     */
    public function getByParamIdentification(array $parameters): ?EntityApiInterface
    {
        return $this->get($this->getParamIdentificationArray($parameters));
    }

    /**
     * @param array $parameters
     * @return array
     */
    abstract public function getParamIdentificationArray(array $parameters): array;

    /**
     * @param EntityApiInterface $entity
     * @param array $parameters
     * @return EntityApiInterface
     */
    public function put(EntityApiInterface $entity, array $parameters = []): EntityApiInterface
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PUT, false);
    }


    /**
     * @param EntityApiInterface $entity
     * @param array $parameters
     * @return EntityApiInterface
     */
    public function desactivate(EntityApiInterface $entity, array $parameters = []): EntityApiInterface
    {
        return $this->patch($entity->desactivate(), $parameters);
    }

    /**
     * @param EntityApiInterface $entity
     * @param array|null $parameters
     * @return EntityApiInterface
     */
    public function patch(EntityApiInterface $entity, array $parameters = []): EntityApiInterface
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PATCH, false);
    }

    /**
     * @param EntityApiInterface $entity
     * @return EntityApiInterface
     */
    public function delete(EntityApiInterface $entity): EntityApiInterface
    {
        $this->prepareToDeletion($entity);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    /**
     * @param EntityApiInterface $entity
     * @return EntityApiInterface
     */
    public function prepareToDeletion(EntityApiInterface $entity): EntityApiInterface
    {
        return $entity->desactivate();
    }

    /**
     * @param EntityApiInterface $entity
     * @param array $parameters
     * @return EntityApiInterface
     */
    public function activate(EntityApiInterface $entity, array $parameters = []): EntityApiInterface
    {
        return $this->patch($entity->activate(), $parameters);
    }

}
