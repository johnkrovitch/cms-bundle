<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder;

use Pagerfanta\PagerfantaInterface;

interface ArticleFinderInterface
{
    public function findByTags(string $tag): PagerfantaInterface;

    public function findByTerms(array $terms): PagerfantaInterface;
}
