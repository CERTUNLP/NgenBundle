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
interface ApiHandlerInterface
{

    /**
     * Get a Entity given the identifier
     *
     * @param array $parameters
     * @return object
     * @api
     *
     */
    public function get(array $parameters);

    /**
     * Get a list of Entities.
     *
     * @param array $params
     * @param array $order
     * @param int $limit the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all(array $params = array(), $order = array(), $limit = null, $offset = null);

    /**
     * Post Entity, creates a new Entity.
     *
     * @param array $parameters
     *
     * @param bool $csrf_protection
     * @param $entity
     * @return object
     * @api
     *
     */
    public function post(array $parameters, bool $csrf_protection = false, $entity);

    /**
     * Edit a Entity.
     *
     * @param object $entity
     * @param array $parameters
     *
     * @return object
     * @api
     *
     */
    public function put($entity, array $parameters);

    /**
     * Partially update a Entity.
     *
     * @param object $entity
     * @param array $parameters
     *
     * @return object
     * @api
     *
     */
    public function patch($entity, array $parameters);

    /**
     * Delete a Entity.
     *
     * @param object $entity
     * @param array $parameters
     *
     * @return object
     */
    public function delete($entity, array $parameters);
}
