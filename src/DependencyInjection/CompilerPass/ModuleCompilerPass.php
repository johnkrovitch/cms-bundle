<?php

namespace JK\CmsBundle\DependencyInjection\CompilerPass;

use JK\CmsBundle\JKCmsBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ModuleCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(JKCmsBundle::class)) {
            return;
        }
        $moduleDefinitions = $container->findTaggedServiceIds(JKCmsBundle::SERVICE_TAG_MODULE);
        $moduleRepositoryDefinition = $container->findDefinition(JKCmsBundle::SERVICE_ID_MODULE_REPOSITORY);

        foreach ($moduleDefinitions as $id => $moduleDefinition) {
            $moduleRepositoryDefinition->addMethodCall('addModule', [
                new Reference($id),
            ]);
        }
    }
}
