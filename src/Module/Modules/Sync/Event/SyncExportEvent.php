<?php

namespace JK\CmsBundle\Module\Modules\Sync\Event;

use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SyncExportEvent extends Event
{
    const NAME = 'cms.sync.export';

    /**
     * @var SyncableInterface[]
     */
    protected $syncItems = [];

    public function addItem(SyncableInterface $syncable): void
    {
        $this->syncItems[] = $syncable;
    }

    /**
     * @return SyncableInterface[]
     */
    public function getItems(): array
    {
        return $this->syncItems;
    }
}
