<?php

namespace JK\CmsBundle\Module\Configuration\Loader;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class ConfigurationLoader implements ConfigurationLoaderInterface
{
    /**
     * @var string
     */
    private $moduleDirectory;

    /**
     * @var array
     */
    private $configuration;

    public function __construct(string $moduleDirectory)
    {
        $this->moduleDirectory = $moduleDirectory;
    }

    public function load(string $moduleName): array
    {
        $this->loadConfiguration();

        return $this->resolveConfiguration($moduleName);
    }

    private function loadConfiguration(): void
    {
        if (null !== $this->configuration) {
            return;
        }
        $finder = new Finder();
        $finder
            ->files()
            ->in($this->moduleDirectory)
            ->name('*.yaml')
        ;
        $this->configuration = [];

        foreach ($finder as $fileInfo) {
            $this->configuration += Yaml::parseFile($fileInfo->getRealPath());
        }
    }

    private function resolveConfiguration(string $moduleName): array
    {
        return empty($this->configuration[$moduleName]) ? [] : $this->configuration[$moduleName];
    }
}
