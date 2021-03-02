<?php

namespace JK\CmsBundle\Module\Render;

use JK\CmsBundle\Module\Exception\NotViewableModuleException;
use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\ViewableModuleInterface;
use Twig\Environment;

class ModuleRenderer implements ModuleRendererInterface
{
    private Environment $environment;
    
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }
    
    public function render(ModuleInterface $module, string $view = null, array $options = []): string
    {
        if ($module instanceof ViewableModuleInterface) {
            throw new NotViewableModuleException($module->getName());
        }
        $view = $module->createView($view, $options);
    
        return $this->environment->render($view->getTemplate(), $view->getParameters());
    }
}
