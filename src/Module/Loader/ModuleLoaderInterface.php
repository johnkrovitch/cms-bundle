<?php

namespace JK\CmsBundle\Module\Loader;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

interface ModuleLoaderInterface
{
    public function loadModule(ModuleInterface $module, Request $request, array $options = []): void;
}
