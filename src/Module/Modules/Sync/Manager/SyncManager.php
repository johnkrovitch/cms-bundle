<?php

namespace JK\CmsBundle\Module\Modules\Sync\Manager;

use JK\CmsBundle\Module\Modules\Sync\Model\SyncItem;
use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class SyncManager implements SyncManagerInterface
{
    /**
     * @var string
     */
    private $projectDirectory;

    /**
     * @var string
     */
    private $syncPath;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    public function __construct(string $projectDirectory)
    {
        $this->projectDirectory = $projectDirectory;
        $this->syncPath = $this->projectDirectory.'/fixtures/cms/modules';
        $this->fileSystem = new Filesystem();
    }

    public function create(string $identifier, string $group, array $data): SyncableInterface
    {
        return new SyncItem($identifier, $group, $data);
    }

    public function export(SyncableInterface $syncable): void
    {
        if (!$this->fileSystem->exists($this->syncPath)) {
            $this->fileSystem->mkdir($this->syncPath);
        }
        $file = $this->syncPath.'/'.$syncable->getSyncGroup().'.yaml';

        if (!$this->fileSystem->exists($file)) {
            $this->fileSystem->touch($file);
        }
        $data = Yaml::parse(file_get_contents($file));

        if (false === $data) {
            $data = [];
        }
        $data[$syncable->getSyncIdentifier()] = $syncable->exportSync();

        file_put_contents($file, Yaml::dump($data));
    }

    public function import(): array
    {
        $items = [];

        if (!$this->fileSystem->exists($this->syncPath)) {
            return $items;
        }
        $finder = new Finder();
        $finder
            ->in($this->syncPath)
            ->files()
            ->name('*.yaml')
        ;

        foreach ($finder as $fileInfo) {
            $data = Yaml::parse(file_get_contents($fileInfo->getRealPath()));
            $group = str_replace('.yaml', '', $fileInfo->getFilename());
            $items[$group] = $data;
        }

        return $items;
    }
}
