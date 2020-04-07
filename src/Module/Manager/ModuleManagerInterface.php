<?php

namespace JK\CmsBundle\Module\Manager;

use JK\CmsBundle\Module\Render\ModuleView;

interface ModuleManagerInterface
{
    public function load(): void;

    public function render(string $moduleName): ModuleView;
}
