<?php

namespace JK\CmsBundle\Module\Loader;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

class ModuleLoader implements ModuleLoaderInterface
{
    public function loadModule(ModuleInterface $module, Request $request, array $options = []): void
    {
        $module->load($request, $options);
        $module->setLoaded();
    }
}
