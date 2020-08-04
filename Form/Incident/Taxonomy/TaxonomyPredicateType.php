<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Incident\Taxonomy;

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyPredicateType extends EntityForm
{
    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => TaxonomyPredicate::class,
        ));
    }


}
