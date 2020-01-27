<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\Registry\ModuleRegistryInterface;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\RenderModuleInterface;

class ModuleManager implements ModuleManagerInterface
{
    /**
     * @var ModuleRegistryInterface
     */
    private $registry;

    public function __construct(ModuleRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function load(): void
    {
        $this->registry->load();
    }

    public function render(string $moduleName): ModuleView
    {
        $module = $this->registry->get($moduleName);

        if (!$module instanceof RenderModuleInterface) {
            throw new Exception(sprintf('The module "%s" can not rendered. It must implements %s', $moduleName, RenderModuleInterface::class));
        }

        if (!$module->isLoaded()) {
            $module->load();
        }

        return $module->render();
    }
}
