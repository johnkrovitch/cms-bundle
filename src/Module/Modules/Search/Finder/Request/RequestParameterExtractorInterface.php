<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder\Request;

use JK\CmsBundle\Module\Modules\Search\Finder\Model\Search;
use Symfony\Component\HttpFoundation\Request;

interface RequestParameterExtractorInterface
{
    public function extract(Request $request): Search;
}
