<?php

namespace JK\CmsBundle\Module\Render;

use JK\CmsBundle\Module\ModuleInterface;

interface ModuleRendererInterface
{
    public function render(ModuleInterface $module, string $view,  array $options = []): string;
}
