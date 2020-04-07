<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ModuleExtension extends AbstractExtension
{
    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    /**
     * @var Environment
     */
    private $environment;

    public function __construct(ModuleManagerInterface $moduleManager, Environment $environment)
    {
        $this->moduleManager = $moduleManager;
        $this->environment = $environment;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cms_render_module', [$this, 'renderModule']),
        ];
    }

    public function renderModule(string $moduleName): string
    {
        $view = $this
            ->moduleManager
            ->render($moduleName)
        ;

        return $this->environment->render($view->getTemplate(), $view->getParameters());
    }
}
