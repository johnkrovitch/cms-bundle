<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestParameterExtractorInterface
{
    public function extract(Request $request): array;
}
