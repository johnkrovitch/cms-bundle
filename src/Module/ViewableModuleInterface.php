<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Module\View\ModuleView;

interface ViewableModuleInterface extends ModuleInterface
{
    public function createView(string $view = null, array $options = []): ModuleView;
}
