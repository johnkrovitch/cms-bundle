<?php

namespace JK\CmsBundle\Module;

interface ModuleInterface
{
    /**
     * Return the module name.
     */
    public function getName(): string;

    /**
     * Load data required by the module to work.
     */
    public function load(): void;

    /**
     * Return true if the module is enabled and should be loaded and rendered.
     */
    public function isEnabled(): bool;

    /**
     * Return true if the module has been loaded, to avoid loading twice.
     */
    public function isLoaded(): bool;
}
