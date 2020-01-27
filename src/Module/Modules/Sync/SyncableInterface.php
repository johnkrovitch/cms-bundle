<?php

namespace JK\CmsBundle\Module\Modules\Sync;

interface SyncableInterface
{
    public function getSyncIdentifier(): string;

    public function getSyncGroup(): string;

    public function exportSync(): array;

    public function importSync(array $data): void;
}
