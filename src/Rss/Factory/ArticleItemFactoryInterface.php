<?php

namespace JK\CmsBundle\Rss\Factory;

interface ArticleItemFactoryInterface
{
    public function create(array $articles): array;
}
