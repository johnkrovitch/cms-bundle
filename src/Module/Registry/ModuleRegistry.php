<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\ModuleInterface;

class ModuleRegistry implements ModuleRegistryInterface
{
    protected array $modules = [];

    public function __construct(iterable $modules)
    {
        foreach ($modules as $module) {
            $this->modules[$module->getName()] = $module;
        }
    }

//    public function load(string $module): void
//    {
//        foreach ($this->modules as $module) {
//            if (!$module->supports($request) || $module->isLoaded()) {
//                continue;
//            }
//            $this->loadModule($module, $request);
//
//            if ($module->isLoaded()) {
//                $this->loadedModules[] = $module;
//            }
//        }
//    }
//
//    public function loadModule(ModuleInterface $module, Request $request, array $options = []): void
//    {
//        $this->configureModule($module, $this->loader->load($module->getName()));
//
//        if (!empty($moduleConfiguration['enabled']) && false === $moduleConfiguration['enabled']) {
//            return;
//        }
//        $module->load($request, $options);
//        $module->setLoaded();
//    }

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
