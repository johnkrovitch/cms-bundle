<?php

namespace JK\CmsBundle\Module\Modules\Sync\Manager;

use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;

interface SyncManagerInterface
{
    public function create(string $identifier, string $group, array $data): SyncableInterface;

    public function export(SyncableInterface $syncable): void;

    public function import(): array;
}
