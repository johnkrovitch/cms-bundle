<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Module\ModuleInterface;

interface ModuleRegistryInterface
{
    public function load(): void;

    public function get(string $moduleName): ModuleInterface;

    public function has(string $moduleName): bool;

    public function all(): array;
}
