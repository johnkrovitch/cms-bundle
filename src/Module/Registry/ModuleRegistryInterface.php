<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

interface ModuleRegistryInterface
{
    public function load(Request $request): void;

    public function loadModule(ModuleInterface $module, Request $request, array $options = []): void;

    public function get(string $moduleName): ModuleInterface;

    public function has(string $moduleName): bool;

    public function all(): array;
}
