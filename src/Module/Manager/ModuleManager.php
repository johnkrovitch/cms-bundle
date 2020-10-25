<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\RenderModuleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ModuleManager implements ModuleManagerInterface
{
    /**
     * @var ModuleRegistryInterface
     */
    private $registry;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(ModuleRegistryInterface $registry, RequestStack $requestStack)
    {
        $this->registry = $registry;
        $this->requestStack = $requestStack;
    }

    public function load(Request $request): void
    {
        $this->registry->load($request);
    }

    public function render(string $moduleName, array $options = []): ModuleView
    {
        $module = $this->registry->get($moduleName);

        if (!$module instanceof RenderModuleInterface) {
            throw new Exception(sprintf('The module "%s" can not rendered. It must implements %s', $moduleName, RenderModuleInterface::class));
        }

        if (!$module->isLoaded()) {
            $this->registry->loadModule($module, $this->requestStack->getCurrentRequest(), $options);
        }

        return $module->render($options);
    }

    public function get(string $name): ModuleInterface
    {
        return $this->registry->get($name);
    }
}
