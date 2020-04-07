<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Module\Render\ModuleView;

interface RenderModuleInterface extends ModuleInterface
{
    public function getZones(): array;

    public function render(): ModuleView;
}
