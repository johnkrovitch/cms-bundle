<?php

namespace JK\CmsBundle\Module\Resolver;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestModuleResolver implements ModuleResolverInterface
{
    public function resolve(ModuleInterface $module, Request $request): bool
    {
        $modules = $request->attributes->get('modules', '');
        $modules = explode(',', $modules);
    
        return in_array($module->getName(), $modules);
    }
}
