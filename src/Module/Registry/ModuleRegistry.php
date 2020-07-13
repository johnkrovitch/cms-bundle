<?php

namespace JK\CmsBundle\Module\Registry;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\Configuration\Loader\ConfigurationLoaderInterface;
use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleRegistry implements ModuleRegistryInterface
{
    /**
     * @var ModuleInterface[]
     */
    protected $modules;

    /**
     * @var ModuleInterface[]
     */
    protected $loadedModules = [];

    /**
     * @var ConfigurationLoaderInterface
     */
    private $loader;

    public function __construct(iterable $modules, ConfigurationLoaderInterface $loader)
    {
        foreach ($modules as $module) {
            $this->modules[$module->getName()] = $module;
        }
        $this->loader = $loader;
    }

    public function load(Request $request): void
    {
        foreach ($this->modules as $module) {
            if (!$module->supports($request) || $module->isLoaded()) {
                continue;
            }
            $this->loadModule($module, $request);

            if ($module->isLoaded()) {
                $this->loadedModules[] = $module;
            }
        }
    }

    public function loadModule(ModuleInterface $module, Request $request, array $options = []): void
    {
        $options = array_merge_recursive($this->loader->load($module->getName()), $options);
        $moduleConfiguration = $this->resolveConfiguration($module, $options);

        if (!empty($moduleConfiguration['enabled']) && false === $moduleConfiguration['enabled']) {
            return;
        }
        $module->load($request, $moduleConfiguration);
        $module->setLoaded();
    }

    public function get(string $moduleName): ModuleInterface
    {
        if (!$this->has($moduleName)) {
            throw new Exception(sprintf('The module "%s" does not exists', $moduleName));
        }

        return $this->modules[$moduleName];
    }

    public function all(): array
    {
        return $this->modules;
    }

    public function has(string $moduleName): bool
    {
        return key_exists($moduleName, $this->modules);
    }

    private function resolveConfiguration(ModuleInterface $module, array $configuration): array
    {
        $resolver = new OptionsResolver();
        $module->configureOptions($resolver);

        try {
            $configuration = $resolver->resolve($configuration);
        } catch (\Exception $exception) {
            throw new Exception(sprintf('An error has occurred when configuring the module "%s".', $module->getName()), $exception->getCode(), $exception);
        }

        return $configuration;
    }
}
