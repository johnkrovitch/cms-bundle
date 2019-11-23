<?php

namespace JK\CmsBundle\DependencyInjection;

use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class JKCmsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator([
            __DIR__.'/../Resources/config',
        ]));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //         $container->setParameter('jk_cms.article.thumbnail_path', $config['article']['thumbnail_path']);

        $helperDefinition = $container->getDefinition(ConfigurationHelper::class);
        $helperDefinition->setArgument(0, $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());

        if (0 === count($configs)) {
            return;
        }
        $config = $configs[0];
        $container->setParameter('cms.config', $config);

        $admin = $config['admin'];

        $container
            ->prependExtensionConfig('lag_admin', [
                'application' => [
                    'title' => $admin['title'],
                    'description' => $admin['description'],
                    'max_per_page' => $admin['max_per_page'],
                    'routing_name_pattern' => $admin['routing_name_pattern'],
                    'routing_url_pattern' => $admin['routing_url_pattern'],
                    'date_format' => $admin['date_format'],
                    'base_template' => $admin['base_template'],
                    'translation' => $admin['translation'],
                    'translation_pattern' => $admin['translation_pattern'],
                    'homepage_route' => $admin['homepage_route'],
                ],
            ])
        ;
    }

    public function getAlias()
    {
        return 'jk_cms';
    }
}
