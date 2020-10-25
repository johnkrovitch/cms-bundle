<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Module\Render\ModuleView;
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

    public function load(Request $request): void;

    public function render(string $moduleName): ModuleView;
}
