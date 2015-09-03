<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Handler;

/**
 *
 * @author demyen
 */
interface ApiHandlerInterface {

    /**
     * Get a Page given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return PageInterface
     */
    public function get($id);

    /**
     * Get a list of Pages.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Page, creates a new Page.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return PageInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Page.
     *
     * @api
     *
     * @param PageInterface   $page
     * @param array           $parameters
     *
     * @return PageInterface
     */
    public function put($page, array $parameters);

    /**
     * Partially update a Page.
     *
     * @api
     *
     * @param PageInterface   $page
     * @param array           $parameters
     *
     * @return PageInterface
     */
    public function patch($page, array $parameters);

    /**
     * Delete a Page.
     *
     * @param PageInterface $page
     * @param array $parameters
     *
     * @return PageInterface
     */
    public function delete($page, array $parameters);
}
