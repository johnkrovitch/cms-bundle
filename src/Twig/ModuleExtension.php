<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

class ModuleExtension extends Twig_Extension
{
    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(ModuleManagerInterface $moduleManager, Twig_Environment $twig)
    {
        $this->moduleManager = $moduleManager;
        $this->twig = $twig;
    }

    /**
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('cms_render_module', [$this, 'cmsRenderModule']),
        ];
    }

    /**
     * @param string $name Module name
     *
     * @return string
     */
    public function cmsRenderModule($name)
    {
        $view = $this
            ->moduleManager
            ->render($name)
        ;

        return $this->twig->render($view->getTemplate(), $view->getParameters());
    }
}
