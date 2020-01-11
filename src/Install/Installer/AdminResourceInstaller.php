<?php

namespace JK\CmsBundle\Install\Installer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Install admin resources files and package configuration file.
 */
class AdminResourceInstaller implements InstallerInterface
{
    /**
     * @var string
     */
    private $projectDirectory;

    public function __construct(string $projectDirectory)
    {
        $this->projectDirectory = $projectDirectory;
    }

    public function install(array $context = []): void
    {
        $this->copyFiles();
        $this->updatePackageConfiguration();
    }

    public function getName(): string
    {
        return 'Admin Resource Installer';
    }

    public function getDescription(): string
    {
        return 'Install admin yaml fixtures to start the cms';
    }

    private function copyFiles(): void
    {
        $adminResourceDirectory = $this->projectDirectory.'/config/admin/resources';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($adminResourceDirectory);

        $fixturesDirectory = __DIR__.'/../../Resources/fixtures/admin/resources';
        $finder = new Finder();
        $finder
            ->in($fixturesDirectory)
            ->files()
            ->name('*.yaml')
        ;

        foreach ($finder as $fileInfo) {
            $targetFile = $adminResourceDirectory.'/'.$fileInfo->getFilename();

            // Do not update existing files
            if ($fileSystem->exists($targetFile)) {
                continue;
            }
            $fileSystem->copy($fileInfo->getRealPath(), $targetFile);
        }
    }

    private function updatePackageConfiguration($force = false): void
    {
        $bundleFile = $this->projectDirectory.'/config/packages/jk_cms.yaml';
        $fileSystem = new Filesystem();

        if ($fileSystem->exists($bundleFile) && !$force) {
            return;
        }
        $fixtureFile = __DIR__.'/../../Resources/fixtures/packages/jk_cms.yaml';
        $fileSystem->copy($fixtureFile, $bundleFile, $force);
    }
}
