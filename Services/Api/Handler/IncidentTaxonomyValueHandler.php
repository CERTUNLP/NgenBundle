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

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;

class IncidentTaxonomyValueHandler extends Handler
{
    /**
     * Delete a TaxonomyValue.
     *
     * @param TaxonomyValue $taxonomy_value
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($taxonomy_value, array $parameters = null)
    {
        $taxonomy_value->setIsActive(FALSE);
    }

    /**
     * @param $taxonomy_value
     * @param $method
     * @return object|null
     */
    protected function checkIfExists($taxonomy_value, $method)
    {
        $taxonomy_valueDB = $this->repository->findOneBy(array('slug' => $taxonomy_value->getSlug()));

        if ($taxonomy_valueDB && $method == 'POST') {
            $taxonomy_value = $taxonomy_valueDBs;
        }
        return $taxonomy_value;
    }


}