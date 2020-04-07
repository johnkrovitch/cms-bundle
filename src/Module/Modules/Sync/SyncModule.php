<?php

namespace JK\CmsBundle\Module\Modules\Sync;

use JK\CmsBundle\Module\AbstractModule;

class SyncModule extends AbstractModule
{
    public function getName(): string
    {
        return 'sync';
    }

    public function load(): void
    {
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
