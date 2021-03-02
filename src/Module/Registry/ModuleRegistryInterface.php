<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Module\ModuleInterface;

interface ModuleRegistryInterface
{
    public function get(string $moduleName): ModuleInterface;

    public function has(string $moduleName): bool;
    
    /**
     * @return ModuleInterface[]
     */
    public function all(): array;
}
