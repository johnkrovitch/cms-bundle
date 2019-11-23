<?php

namespace JK\CmsBundle\Module;

use LAG\Component\StringUtils\StringUtils;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractModule implements ModuleInterface
{
    public function supports(Request $request): bool
    {
        if ($request->isXmlHttpRequest()) {
            return false;
        }

        if (!StringUtils::startsWith($request->attributes->get('_route'), 'lecomptoir.')) {
            return false;
        }

        return true;
    }
}
