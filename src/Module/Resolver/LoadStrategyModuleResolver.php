<?php

namespace JK\CmsBundle\Module\Resolver;

use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use function Symfony\Component\String\u;

class LoadStrategyModuleResolver implements ModuleResolverInterface
{
    private ModuleRegistryInterface $registry;
    
    public function __construct(ModuleRegistryInterface $registry)
    {
        $this->registry = $registry;
    }
    
    public function resolve(ModuleInterface $module, Request $request): bool
    {
        $loadStrategy = $module->getOption('load_strategy');
    
        if ($loadStrategy === ModuleInterface::LOAD_STRATEGY_ALWAYS) {
            return true;
        }
    
        if ($loadStrategy === ModuleInterface::LOAD_STRATEGY_EXPLICIT) {
            return false;
        }
    
        if ($loadStrategy === ModuleInterface::LOAD_STRATEGY_CMS) {
            return u($request->getPathInfo())->startsWith('/cms');
        }
    
        if ($loadStrategy === ModuleInterface::LOAD_STRATEGY_CMS) {
            return !u($request->getPathInfo())->startsWith('/cms');
        }
        
        return false;
    }
}
