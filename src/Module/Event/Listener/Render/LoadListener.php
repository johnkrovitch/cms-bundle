<?php

namespace JK\CmsBundle\Module\Event\Listener\Render;

use JK\CmsBundle\Module\Event\RenderEvent;
use JK\CmsBundle\Module\Exception\ModuleConfigurationException;
use JK\CmsBundle\Module\Loader\ModuleLoaderInterface;
use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LoadListener
{
    private ModuleLoaderInterface $loader;
    private RequestStack $requestStack;
    
    public function __construct(ModuleLoaderInterface $loader, RequestStack $requestStack)
    {
        $this->loader = $loader;
        $this->requestStack = $requestStack;
    }
    
    public function __invoke(RenderEvent $event)
    {
        $module = $event->getModule();
    
        if ($module->isLoaded()) {
            return;
        }
    
        if ($module->getOption('load_strategy') !== ModuleInterface::LOAD_STRATEGY_EXPLICIT) {
            throw new ModuleConfigurationException(sprintf(
                'The module "%s" is not loaded and the loading strategy for this module is not explicit',
                $module->getName()
            ));
        }
        $this->loader->loadModule($module, $this->requestStack->getCurrentRequest());
    }
}
