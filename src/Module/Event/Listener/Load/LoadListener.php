<?php

namespace JK\CmsBundle\Module\Event\Listener\Load;

use JK\CmsBundle\Module\Configuration\Configurator\ModuleConfiguratorInterface;
use JK\CmsBundle\Module\Event\LoadModulesEvent;
use JK\CmsBundle\Module\Loader\ModuleLoaderInterface;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use JK\CmsBundle\Module\Resolver\ModuleResolverInterface;

class LoadListener
{
    private ModuleRegistryInterface $registry;
    private ModuleConfiguratorInterface $configurator;
    private ModuleLoaderInterface $loader;
    private ModuleResolverInterface $resolver;
    
    public function __construct(
        ModuleRegistryInterface $registry,
        ModuleConfiguratorInterface $configurator,
        ModuleLoaderInterface $loader,
        ModuleResolverInterface $resolver
    ) {
        $this->registry = $registry;
        $this->configurator = $configurator;
        $this->loader = $loader;
        $this->resolver = $resolver;
    }
    
    public function __invoke(LoadModulesEvent $event): void
    {
        foreach ($this->registry->all() as $module) {
            if (!$module->isConfigured()) {
                $this->configurator->configure($module);
            }
    
            if ($this->resolver->resolve($module, $event->getRequest())) {
                $this->loader->loadModule($module, $event->getRequest());
            }
        }
    }
}
