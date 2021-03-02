<?php

namespace JK\CmsBundle\Module\Configuration\Configurator;

use Exception;
use JK\CmsBundle\Module\Configuration\Loader\ConfigurationLoaderInterface;
use JK\CmsBundle\Module\Exception\ModuleConfigurationException;
use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleConfigurator implements ModuleConfiguratorInterface
{
    private ConfigurationLoaderInterface $loader;
    
    public function __construct(ConfigurationLoaderInterface $loader)
    {
        $this->loader = $loader;
    }
    
    public function configure(ModuleInterface $module): void
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefaults([
                'load_strategy' => ModuleInterface::LOAD_STRATEGY_EXPLICIT,
            ])
        ;
        $module->configure($resolver);
        $configuration = $this->loader->load($module->getName());
    
        try {
            $configuration = $resolver->resolve($configuration);
            $module->setOptions($configuration);
        } catch (Exception $exception) {
            throw new ModuleConfigurationException(
                sprintf(
                    'An error has occurred when configuring the module "%s": "%s"',
                    $module->getName(),
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        }
    }
}
