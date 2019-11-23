<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Render\ModuleView;
use LogicException;
use Symfony\Component\HttpFoundation\Request;

class ModuleManager implements ModuleManagerInterface
{
    /**
     * @var ModuleInterface[]
     */
    private $modules;

    public function __construct(array $modules = [])
    {
        foreach ($modules as $module) {
            if (!$module instanceof ModuleInterface) {
                throw new LogicException('The module should be an instance of '.ModuleInterface::class);
            }
            $this->modules[$module->getName()] = $module;
        }
    }

    public function load(Request $request): void
    {
        foreach ($this->modules as $module) {
            if (!$module->supports($request)) {
                continue;
            }
            $module->load($request);
        }
    }

    public function render(string $moduleName): ModuleView
    {
        return $this->modules[$moduleName]->render();
    }
}
