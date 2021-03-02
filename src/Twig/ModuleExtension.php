<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ModuleExtension extends AbstractExtension
{
    private ModuleManagerInterface $moduleManager;

    public function __construct(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cms_render_module', [$this, 'renderModule']),
        ];
    }

    public function renderModule(string $moduleName): string
    {
        return $this
            ->moduleManager
            ->render($moduleName)
        ;

        return $this->environment->render($view->getTemplate(), $view->getParameters());
    }
}
