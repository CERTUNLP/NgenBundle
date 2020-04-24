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

use CertUnlp\NgenBundle\Entity\Entity;
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
     * @param AbstractType $entity_ype
     * @param FormFactoryInterface $form_factory
     */
    public function __construct(EntityManagerInterface $entity_manager, ObjectRepository $repository, AbstractType $entity_ype, FormFactoryInterface $form_factory)
    {
        $this->entity_manager = $entity_manager;
        $this->repository = $repository;
        $this->form_factory = $form_factory;
        $this->entity_type = $entity_ype;
    }


    /**
     * @param array $parameters
     * @return object|null
     */
    public function get(array $parameters): ?Entity
    {
        return $this->getRepository()->findOneBy($parameters);
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->repository;
    }


    /**
     * @param array $params
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return array|Entity[]
     */
    public function all(array $params = [], array $order = [], int $limit = 0, int $offset = 0): array
    {
        return $this->getRepository()->findBy($params, $order, $limit, $offset);
    }


    /**
     * @param array $parameters
     * @param bool $csrf_protection
     * @return Entity
     */
    public function post(array $parameters, bool $csrf_protection = false): Entity
    {
        $entity = $this->createEntityInstance($parameters);

        return $this->processForm($entity, $parameters, Request::METHOD_POST, $csrf_protection);
    }

    /**
     * @param array $params
     * @return Entity
     */
    private function createEntityInstance(array $params = []): Entity
    {
        $class_name = $this->getRepository()->getClassName();
        return new $class_name($params);
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @param string $method
     * @param bool $csrf_protection
     * @return Entity
     */
    public function processForm(Entity $entity, array $parameters = [], string $method = Request::METHOD_PUT, bool $csrf_protection = true): Entity
    {
        $form = $this->getFormFactory()->create($this->getEntityType(), $entity, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $form->submit($parameters, Request::METHOD_PATCH !== $method);

        if ($form->isValid()) {
            $entity = $form->getData();
            $entity = $this->checkIfExists($entity, $method);

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
     * @param Entity $entity
     * @param string $method
     * @return Entity
     */
    abstract public function checkIfExists(Entity $entity, string $method): Entity;

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entity_manager;
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @return Entity
     */
    public function put(Entity $entity, array $parameters = []): Entity
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PUT, false);
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @return Entity
     */
    public function desactivate(Entity $entity, array $parameters = []): Entity
    {
        return $this->delete($entity, $parameters);
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @return Entity
     */
    public function delete(Entity $entity, array $parameters = []): Entity
    {
        $this->prepareToDeletion($entity, $parameters);
        return $this->patch($entity, $parameters);
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @return Entity
     */
    abstract public function prepareToDeletion(Entity $entity, array $parameters = []): Entity;


    /**
     * @param Entity $entity
     * @param array|null $parameters
     * @return Entity
     */
    public function patch(Entity $entity, array $parameters = null): Entity
    {
        return $this->processForm($entity, $parameters, Request::METHOD_PATCH, false);
    }


    /**
     * @param Entity $entity
     * @param array $parameters
     * @return Entity
     */
    public function activate(Entity $entity, array $parameters = []): Entity
    {
        return $this->patch($entity->setActive(true), $parameters);
    }

}
