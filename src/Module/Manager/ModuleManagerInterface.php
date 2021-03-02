<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

interface ModuleManagerInterface
{
    /**
     * Return a module instance.
     *
     * @param string $name
     *
     * @return ModuleInterface
     */
    public function get(string $name): ModuleInterface;

    public function load(Request $request, array $options = []): void;
    
    public function loadModule(Request $request, ModuleInterface $module, array $options = []): void;

    public function render(string $moduleName, array $options = []): string;
}
