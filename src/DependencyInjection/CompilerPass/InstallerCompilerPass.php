<?php

namespace JK\CmsBundle\DependencyInjection\CompilerPass;

use JK\CmsBundle\Install\Installer\InstallerInterface;
use JK\CmsBundle\Install\InstallerRegistry\Registry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class InstallerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(Registry::class)) {
            return;
        }
        $registry = $container->getDefinition(Registry::class);

        foreach ($container->getDefinitions() as $definition) {
            $class = $definition->getClass();

            // Avoid empty string or null
            if (!$class || !class_exists($class)) {
                continue;
            }

            if (in_array(InstallerInterface::class, class_implements($class))) {
                $registry->addMethodCall('add', [
                    new Reference($class),
                ]);
            }
        }
    }
}
