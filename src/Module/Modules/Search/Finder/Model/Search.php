<?php

namespace JK\CmsBundle\Module\Modules\Search\Finder\Model;

class Search
{
    private array $filters;
    private ?string $search;
    
    public function __construct(array $filters = [], string $search = null)
    {
        $this->filters = $filters;
        $this->search = $search;
    }
    
    public function getFilters(): array
    {
        return $this->filters;
    }
    
    public function getSearch(): ?string
    {
        return $this->search;
    }
}
