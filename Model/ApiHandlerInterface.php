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

/**
 *
 * @author dam
 */
interface ApiHandlerInterface {

    /**
     * Get a Entity given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return EntityInterface
     */
    public function get(array $parameters);

    /**
     * Get a list of Entities.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all(array $params = array(), $order = array(), $limit = null, $offset = null);

    /**
     * Post Entity, creates a new Entity.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return EntityInterface
     */
    public function post(array $parameters, $csrf_protection = false);

    /**
     * Edit a Entity.
     *
     * @api
     *
     * @param EntityInterface   $entity
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function put($entity, array $parameters);

    /**
     * Partially update a Entity.
     *
     * @api
     *
     * @param EntityInterface   $entity
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function patch($entity, array $parameters);

    /**
     * Delete a Entity.
     *
     * @param EntityInterface $entity
     * @param array $parameters
     *
     * @return EntityInterface
     */
    public function delete($entity, array $parameters);
}
