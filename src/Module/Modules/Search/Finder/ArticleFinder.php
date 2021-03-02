<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder;

use JK\CmsBundle\Module\Modules\Search\Finder\Request\RequestParameterExtractorInterface;
use JK\CmsBundle\Repository\ArticleRepository;
use Pagerfanta\PagerfantaInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticleFinder implements ArticleFinderInterface
{
    private ArticleRepository $repository;
    private RequestParameterExtractorInterface $extractor;
    
    public function __construct(ArticleRepository $repository, RequestParameterExtractorInterface $extractor)
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
    }

    public function findByTerms(array $terms, int $page = 1): PagerfantaInterface
    {
        return $this->repository->findByTerms($terms, true, $page);
    }

    public function findByFilter(array $filters, int $page = 1): PagerfantaInterface
    {
        return $this
            ->repository
            ->findByFilters($filters)
        ;
    }

    public function find(Request $request): PagerfantaInterface
    {
        $parameters = $this->extractor->extract($request);
        
        if ($request->attributes->has('search')) {
            $articles = $this
                ->repository
                ->findByTerms(explode(' ', $request->attributes->get('cms_search')), true, $request->query->getInt('page', 1))
            ;
        } else {
            $filters = $this->extractFiltersValues($request);
            $articles = $this
                ->repository
                ->findByFilters($filters)
            ;
        }

        return $articles;
    }


}
