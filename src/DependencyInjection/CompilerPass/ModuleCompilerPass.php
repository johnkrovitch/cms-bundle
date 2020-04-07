<?php

namespace JK\CmsBundle\DependencyInjection\CompilerPass;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ModuleCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Register all modules automatically. They will be injected ti the module registry
        $container
            ->registerForAutoconfiguration(ModuleInterface::class)
            ->addTag('cms.module')
        ;
    }
}
