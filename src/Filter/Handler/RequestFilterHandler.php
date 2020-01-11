<?php

namespace JK\CmsBundle\Filter\Handler;

use Symfony\Component\HttpFoundation\Request;

class RequestFilterHandler implements RequestFilterHandlerInterface
{
    public function handle(Request $request): array
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

        return $values;
    }
}
