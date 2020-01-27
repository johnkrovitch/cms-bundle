<?php

namespace JK\CmsBundle\Module\Modules\Front;

use JK\CmsBundle\Module\ModuleInterface;

class FrontModule implements ModuleInterface
{
    public function getName(): string
    {
        return 'front';
    }

    public function load(): void
    {
    }

    public function isEnabled(): bool
    {
        return true;
    }

    public function isLoaded(): bool
    {
        return true;
    }
}
