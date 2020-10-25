<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder;

use Pagerfanta\PagerfantaInterface;

interface ArticleFinderInterface
{
    public function findByTerms(array $terms, int $page = 1): PagerfantaInterface;

    public function findByFilter(array $filters, int $page = 1): PagerfantaInterface;
}
