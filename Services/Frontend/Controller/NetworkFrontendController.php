<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Frontend\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Prefix;
use Elastica\Query\Term;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NetworkFrontendController extends FrontendController
{

    public function searchAutocompleteEntity(Request $request, string $term = '', int $limit = 7, string $defaultSortFieldName = 'createdAt', string $defaultSortDirection = 'desc', string $page = 'page', string $field = ''): JsonResponse
    {
        if (!$term) {
            $term = $request->get('term') ?? $request->get('q') ?? '*';
        }

        $prefix = new Prefix();
        $prefix->setPrefix('addressAndMask', $term);
        $prefix2 = new Term();
        $prefix2->setTerm('isActive', true);

        $bool = new BoolQuery();
        $bool->addShould($prefix)->addMust($prefix2);
        $results = $this->getFinder()->find(Query::create($bool));

        $array = (new ArrayCollection($results))->map(static function ($element) {
            return ['id' => $element->getId(), 'text' => (string)$element];
        });
        return new JsonResponse($array->toArray());
    }

}
