<?php

namespace JK\CmsBundle\DependencyInjection;

use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\PropertyAccess\PropertyAccess;

class JKCmsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator([
            __DIR__.'/../Resources/config',
        ]));
        $loader->load('services.yaml');

        $accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor()
        ;

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('jk_cms.scripts.template', $accessor->getValue($config, '[scripts][template]'));
        $container->setParameter('jk_cms.contact_email', $accessor->getValue($config, '[email][contact_email]'));

        $siteKey = '';

        if (key_exists('recaptcha', $config) && key_exists('site_key', $config['recaptcha'])) {
            $siteKey = $config['recaptcha']['site_key'];
        }
        $container->setParameter('jk_cms.recaptcha.site_key', $siteKey);
        $container->setParameter('jk_cms.front_base', $accessor->getValue($config, '[application][front_base]'));

        $helperDefinition = $container->getDefinition(ConfigurationHelper::class);
        $helperDefinition->setArgument(0, $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());

        if (0 === count($configs)) {
            return;
        }
        $this->load($configs, $container);
        $config = $configs[0];

        if (null === $config) {
            $config = [];
        }

        if (!key_exists('menus', $config)) {
            $config['menus'] = [];
        }

        $container->setParameter('jk_cms.config', $config);

        if (key_exists('admin', $config)) {
            $admin = $config['admin'];
            $container
                ->prependExtensionConfig('lag_admin', [
                    'application' => $admin,
                    'menus' => $config['menus'],
                ])
            ;
        }

        $container->prependExtensionConfig('twig', [
            'globals' => [
                'cms_front_base' => $container->getParameter('jk_cms.front_base'),
            ],
        ]);
    }

    public function getAlias()
    {
        return 'jk_cms';
    }
}
