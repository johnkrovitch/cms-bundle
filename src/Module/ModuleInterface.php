<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ModuleInterface
{
    /**
     * Return the module name.
     */
    public function getName(): string;

    public function supports(Request $request): bool;

    /**
     * Configure the module options resolver to be passed to the load() method.
     */
    public function configureOptions(OptionsResolver $resolver): void;

    /**
     * Load data required by the module to work.
     */
    public function load(Request $request, array $options = []): void;

    /**
     * Return true if the module has been loaded, to avoid loading twice.
     */
    public function isLoaded(): bool;

    /**
     * Set if the module is loaded. It can be load only once.
     *
     * @throws Exception
     */
    public function setLoaded(): void;
}
