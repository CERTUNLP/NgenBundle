<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use \CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Model\ApiHandlerInterface;

abstract class Handler implements ApiHandlerInterface {

    protected $om;
    protected $entityClass;
    protected $repository;
    protected $formFactory;

    public function __construct(ObjectManager $om, $entityClass, $entityType, FormFactoryInterface $formFactory) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
        $this->entityType = $entityType;
    }

    /**
     * Get a Entity by id.
     *
     * @param mixed $id
     *
     * @return Entity
     */
    public function get($id) {
        return $this->repository->findOneBy($id);
    }

    /**
     * Get a list of entities.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all(array $params = array(), $order = array(), $limit = null, $offset = null) {
        return $this->repository->findBy($params, $order, $limit, $offset);
    }

    /**
     * Create a new Entity.
     *
     * @param array $parameters
     *
     * @return Entity
     */
    public function post(array $parameters, $csrf_protection = false) {
        $entity_class_instance = $this->createEntityInstance();

        return $this->processForm($entity_class_instance, $parameters, 'POST', $csrf_protection);
    }

    /**
     * Edit a Entity.
     *
     * @param Entity $entity_class_instance
     * @param array         $parameters
     *
     * @return Entity
     */
    public function put($entity_class_instance, array $parameters) {
        return $this->processForm($entity_class_instance, $parameters, 'PUT', false);
    }

    /**
     * Partially update a Entity.
     *
     * @param Entity $entity_class_instance
     * @param array         $parameters
     *
     * @return Entity
     */
    public function patch($entity_class_instance, array $parameters) {
        return $this->processForm($entity_class_instance, $parameters, 'PATCH', false);
    }

    /**
     * Delete a Entity.
     *
     * @param Entity $entity_class_instance
     * @param array $parameters
     *
     * @return Entity
     */
    public function delete($entity_class_instance, array $parameters) {
        $this->prepareToDeletion($entity_class_instance, $parameters);
        return $this->patch($entity_class_instance, $parameters);
    }

    /**
     * Prepare to delete a Entity.
     *
     * @param Entity $entity_class_instance
     * @param array $parameters
     *
     * @return Entity
     */
    abstract protected function prepareToDeletion($entity_class_instance, array $parameters);

    abstract protected function checkIfExists($entity_class_instance, $method);

    /**
     * Processes the form.
     *
     * @param Entity $entity_class_instance
     * @param array         $parameters
     * @param String        $method
     *
     * @return Entity
     *
     * @throws \CertUnlp\NgenBundle\Exception\InvalidFormException
     */
    protected function processForm($entity_class_instance, $parameters, $method = "PUT", $csrf_protection = true) {

        $form = $this->formFactory->create(new $this->entityType(), $entity_class_instance, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $entity_class_instance = $form->getData();

            $entity_class_instance = $this->checkIfExists($entity_class_instance, $method);
            $this->om->persist($entity_class_instance);
            $this->om->flush($entity_class_instance);

            return $entity_class_instance;
        }
        throw new InvalidFormException
        ('Invalid submitted data', $form);
    }

    private function createEntityInstance() {

        return new $this->entityClass();
    }

}
