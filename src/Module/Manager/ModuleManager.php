<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\Event\Events;
use JK\CmsBundle\Module\Event\LoadModuleEvent;
use JK\CmsBundle\Module\Event\LoadModulesEvent;
use JK\CmsBundle\Module\Event\RenderEvent;
use JK\CmsBundle\Module\Exception\NotLoadedException;
use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ModuleManager implements ModuleManagerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private ModuleRegistryInterface $registry;
    
    public function __construct(EventDispatcherInterface $eventDispatcher, ModuleRegistryInterface $registry)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->registry = $registry;
    }

    public function load(Request $request, array $options = []): void
    {
        $this->eventDispatcher->dispatch(new LoadModulesEvent($request, $options), Events::LOAD_MODULES);
    }
    
    public function loadModule(Request $request, ModuleInterface $module, array $options = []): void
    {
        $this->eventDispatcher->dispatch(new LoadModuleEvent($request, $module, $options), Events::LOAD_MODULE);
    }
    
    public function render(string $moduleName, array $options = []): string
    {
        $module = $this->registry->get($moduleName);
        $this->eventDispatcher->dispatch($event = new RenderEvent($module, $options), Events::RENDER_MODULE);
    
        return $event->getContent();
    }

    public function get(string $name): ModuleInterface
    {
        return $this->registry->get($name);
    }
}
