<?php

namespace JK\CmsBundle\Module;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractFrontModule extends AbstractModule
{
    public function supports(Request $request): bool
    {
        // By default module are enabled only on front-office pages
        return null === $request->attributes->get('_admin');
    }
}
