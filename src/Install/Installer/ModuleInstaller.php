<?php

namespace JK\CmsBundle\Install\Installer;

class ModuleInstaller implements InstallerInterface
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
    }

    public function getName(): string
    {
        return 'module';
    }

    public function getDescription(): string
    {
        return 'Install the CMD modules files into the modules directory';
    }
}
