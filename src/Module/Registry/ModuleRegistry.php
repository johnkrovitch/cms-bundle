<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\ModuleInterface;

class ModuleRegistry implements ModuleRegistryInterface
{
    /**
     * @var ModuleInterface[]
     */
    protected $modules;

    /**
     * @var ModuleInterface[]
     */
    protected $loadedModules = [];

    public function __construct(iterable $modules)
    {
        foreach ($modules as $module) {
            $this->modules[$module->getName()] = $module;
        }
    }

    public function load(): void
    {
        foreach ($this->modules as $module) {
            $module->load();

            if ($module->isEnabled()) {
                $this->loadedModules[] = $module;
            }
        }
    }

    public function get(string $moduleName): ModuleInterface
    {
        if (!$this->has($moduleName)) {
            throw new Exception(sprintf('The module "%s" does not exists', $moduleName));
        }

        return $this->modules[$moduleName];
    }

    public function all(): array
    {
        return $this->modules;
    }

    public function has(string $moduleName): bool
    {
        return key_exists($moduleName, $this->modules);
    }
}
