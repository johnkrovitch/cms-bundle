<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder\Request;

use JK\CmsBundle\Module\Modules\Search\Finder\Model\Search;
use Symfony\Component\HttpFoundation\Request;

class RequestParameterExtractor implements RequestParameterExtractorInterface
{
    public function extract(Request $request): Search
    {
        $filters = [
            'categorySlug',
            'tagSlug',
            'tag',
            'slug',
            'year',
            'month',
            'page',
        ];
        $values = [];

        foreach ($filters as $filter) {
            if ($request->query->has($filter)) {
                $values[$filter] = $request->query->get($filter);
            }

            if ($request->attributes->has($filter)) {
                $values[$filter] = $request->attributes->get($filter);
            }
        }

        return new Search($values, $request->get('search'));
    }
}
