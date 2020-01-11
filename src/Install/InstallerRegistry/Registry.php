<?php

namespace JK\CmsBundle\Install\InstallerRegistry;

use JK\CmsBundle\Install\Installer\InstallerInterface;

class Registry
{
    private $installers = [];

    public function add(InstallerInterface $installer): void
    {
        $this->installers[get_class($installer)] = $installer;
    }

    public function remove(InstallerInterface $installer): void
    {
        unset($this->installers[get_class($installer)]);
    }

    public function clear(): void
    {
        $this->installers = [];
    }

    public function get(string $class): InstallerInterface
    {
        return $this->installers[$class];
    }

    /**
     * @return InstallerInterface[]
     */
    public function all(): array
    {
        return $this->installers;
    }
}
