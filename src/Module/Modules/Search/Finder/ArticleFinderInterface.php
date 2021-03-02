<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder;

use Pagerfanta\PagerfantaInterface;
use Symfony\Component\HttpFoundation\Request;

interface ArticleFinderInterface
{
    public function find(Request $request): PagerfantaInterface;
    
    public function findByTerms(array $terms, int $page = 1): PagerfantaInterface;

    public function findByFilter(array $filters, int $page = 1): PagerfantaInterface;
}
