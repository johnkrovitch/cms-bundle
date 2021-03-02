<?php

namespace JK\CmsBundle\Module\Event\Listener\Render;

use JK\CmsBundle\Module\Event\RenderEvent;
use JK\CmsBundle\Module\Exception\NotLoadedException;
use JK\CmsBundle\Module\Render\ModuleRendererInterface;

class RenderListener
{
    private ModuleRendererInterface $renderer;
    
    public function __construct(ModuleRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    
    public function __invoke(RenderEvent $event): void
    {
        $module = $event->getModule();
        
        if (!$module->isLoaded()) {
            throw new NotLoadedException($module->getName());
        }
        $content = $this->renderer->render($module, $event->getOptions());
        $event->setContent($content);
    }
}
