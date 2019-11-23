<?php

namespace JK\CmsBundle;

use JK\CmsBundle\DependencyInjection\CompilerPass\ModuleCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JKCmsBundle extends Bundle
{
    const SERVICE_TAG_MODULE = 'cms.module';

    const SERVICE_ID_MODULE_REPOSITORY = 'cms.module.repository';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ModuleCompilerPass());
    }
}
