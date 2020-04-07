<?php

namespace JK\CmsBundle\Module\Modules\Sync\Event;

use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SyncImportEvent extends Event
{
    const NAME = 'cms.sync.import';

    /**
     * @var SyncableInterface[]
     */
    protected $syncItems = [];

    public function __construct(array $syncItems)
    {
        $this->syncItems = $syncItems;
    }

    /**
     * @return SyncableInterface[]
     */
    public function getItems(): array
    {
        return $this->syncItems;
    }

    public function getItemsByGroup(string $group): array
    {
        $items = [];

        foreach ($this->syncItems as $syncable) {
            if ($syncable->getSyncGroup() === $group) {
                $items[$syncable->getSyncIdentifier()] = $syncable;
            }
        }

        return $items;
    }

    public function getItem(string $identifier): SyncableInterface
    {
        return $this->syncItems[$identifier];
    }
}
