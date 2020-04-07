<?php

namespace JK\CmsBundle\Module\Modules\Sync\Model;

use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;

class SyncItem implements SyncableInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $group;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $identifier, string $group, array $data)
    {
        $this->identifier = $identifier;
        $this->group = $group;
        $this->data = $data;
    }

    public function getSyncIdentifier(): string
    {
        return $this->identifier;
    }

    public function getSyncGroup(): string
    {
        return $this->group;
    }

    public function exportSync(): array
    {
        return $this->data;
    }

    public function importSync(array $data): void
    {
        $this->data = $data;
    }
}
