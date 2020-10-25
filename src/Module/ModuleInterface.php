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

    /**
     * Return true if the module supports the current request.
     */
    public function supports(Request $request): bool;

    /**
     * Return the module configuration. If the module configuration is not defined, an exception will be thrown.
     *
     * @throws Exception
     */
    public function getConfiguration(): array;

    /**
     * Define the module configuration. It can be set only once.
     *
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void;

    /**
     * Configure the module options resolver to get the configuration passed to the setConfiguration() method.
     */
    public function configure(OptionsResolver $resolver): void;

    /**
     * Return true if the module is already configured.
     */
    public function isConfigured(): bool;

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
