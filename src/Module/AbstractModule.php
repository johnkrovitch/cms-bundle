<?php

namespace JK\CmsBundle\Module;

abstract class AbstractModule implements ModuleInterface
{
    protected $loaded = false;

    public function isLoaded(): bool
    {
        return $this->loaded;
    }
}
