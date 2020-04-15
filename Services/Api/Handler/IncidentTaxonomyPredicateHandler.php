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

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;

class IncidentTaxonomyPredicateHandler extends Handler
{
    /**
     * Delete a TaxonomyPredicate.
     *
     * @param TaxonomyPredicate $taxonomy_predicate
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($taxonomy_predicate, array $parameters = null)
    {
        $taxonomy_predicate->setIsActive(FALSE);
    }

    /**
     * @param $taxonomy_predicate
     * @param $method
     * @return object|null
     */
    protected function checkIfExists($taxonomy_predicate, $method)
    {
        $taxonomy_predicateDB = $this->repository->findOneBy(array('slug' => $taxonomy_predicate->getSlug()));

        if ($taxonomy_predicateDB && $method === 'POST') {
            $taxonomy_predicate = $taxonomy_predicateDB;
        }
        return $taxonomy_predicate;
    }


}