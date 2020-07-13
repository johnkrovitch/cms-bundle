<?php

namespace JK\CmsBundle\Module\Configuration\Loader;

interface ConfigurationLoaderInterface
{
    /**
     * Load the configuration for the given module. If no configuration found, an empty array is returned.
     */
    public function load(string $moduleName): array;
}
