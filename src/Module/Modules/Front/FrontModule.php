<?php

namespace JK\CmsBundle\Module\Modules\Front;

use JK\CmsBundle\Module\AbstractFrontModule;

class FrontModule extends AbstractFrontModule
{
    public function getName(): string
    {
        return 'front';
    }

    public function isLoaded(): bool
    {
        return true;
    }
}
