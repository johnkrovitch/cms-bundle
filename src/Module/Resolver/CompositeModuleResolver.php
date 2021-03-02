<?php

namespace JK\CmsBundle\Module\Resolver;

use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use Symfony\Component\HttpFoundation\Request;

class CompositeModuleResolver implements ModuleResolverInterface
{
    /**
     * @var iterable<ModuleResolverInterface>
     */
    private iterable $resolvers;
    private ModuleRegistryInterface $registry;
    
    public function __construct(iterable $resolvers, ModuleRegistryInterface $registry)
    {
        $this->resolvers = $resolvers;
        $this->registry = $registry;
    }
    
    public function resolve(ModuleInterface $module, Request $request): bool
    {
        foreach ($this->resolvers as $supporter) {
            if ($supporter->resolve($module, $request)) {
                return true;
            }
        }
    
        return false;
    }
}
