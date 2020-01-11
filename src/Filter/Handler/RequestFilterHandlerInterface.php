<?php

namespace JK\CmsBundle\Filter\Handler;

use Symfony\Component\HttpFoundation\Request;

interface RequestFilterHandlerInterface
{
    /**
     * Handle a request and return a list of values to filter articles, according to the request contains content.
     */
    public function handle(Request $request): array;
}
