<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\Render\ModuleView;
use Symfony\Component\HttpFoundation\Request;

interface ModuleManagerInterface
{
    public function load(Request $request): void;

    public function render(string $moduleName): ModuleView;
}
