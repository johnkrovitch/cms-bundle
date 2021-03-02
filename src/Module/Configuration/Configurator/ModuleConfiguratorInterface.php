<?php

namespace JK\CmsBundle\Module\Configuration\Configurator;

use JK\CmsBundle\Module\ModuleInterface;

interface ModuleConfiguratorInterface
{
    public function configure(ModuleInterface $module): void;
}
