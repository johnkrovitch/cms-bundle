<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\View\ModuleViewInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ModuleInterface
{
    const LOAD_STRATEGY_EXPLICIT = 'explicit';
    const LOAD_STRATEGY_ALWAYS = 'always';
    const LOAD_STRATEGY_FRONT = 'front';
    const LOAD_STRATEGY_CMS = 'cms';
    
    /**
     * Return the module name.
     */
    public function getName(): string;

    /**
     * Return the module configuration. If the module configuration is not defined, an exception will be thrown.
     *
     * @throws Exception
     */
    public function getOptions(): array;

    /**
     * Define the module configuration. It can be set only once.
     *
     * @param array $options
     */
    public function setOptions(array $options): void;
    
    public function hasOption(string $option): bool;
    
    public function getOption(string $option);

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
