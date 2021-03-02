<?php

namespace JK\CmsBundle\Module\Resolver;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

interface ModuleResolverInterface
{
    /**
     * Returns if the given module can be loaded on the current request.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function resolve(ModuleInterface $module, Request $request): bool;
}
