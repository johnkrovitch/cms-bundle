<?php

namespace JK\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('jk_cms');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->arrayNode('application')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('name')->defaultValue('JK CmsBundle')->end()
                            ->arrayNode('comments')
                                ->children()
                                    ->scalarNode('show_route')->end()
                                    ->arrayNode('show_route_parameters')
                                        ->scalarPrototype()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('email')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('base_template')->defaultValue('@JK/Cms/Mail/base.html.twig')->end()
                            ->scalarNode('contact_email')->defaultValue('admin@admin.com')->end()
                        ->end()
                    ->end()
                    ->arrayNode('scripts')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('template')->defaultValue('@JKCms/Assets/script.template.html.twig')->end()
                        ->end()
                    ->end()
                    ->arrayNode('recaptcha')
                        ->children()
                            ->scalarNode('site_key')->end()
                        ->end()
                    ->end()
                    ->arrayNode('admin')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue('CMS Admin')->end()
                            ->scalarNode('description')->defaultValue('Administration of the CMS')->end()
                            ->integerNode('max_per_page')->defaultValue(25)->end()
                            ->scalarNode('routing_name_pattern')->defaultValue('cms.{admin}.{action}')->end()
                            ->scalarNode('routing_url_pattern')->defaultValue('/{admin}/{action}')->end()
                            ->scalarNode('date_format')->defaultValue('Y-m-d')->end()
                            ->scalarNode('base_template')->defaultValue('@JKCms/base.html.twig')->end()
                            ->arrayNode('translation')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('enabled')->defaultTrue()->end()
                                    ->scalarNode('pattern')->defaultValue('cms.{admin}.{key}')->end()
                                    ->scalarNode('catalog')->defaultValue('messages')->end()
                                ->end()
                            ->end()
                            ->scalarNode('homepage_route')->defaultValue('cms.homepage')->end()
                        ->end()
                    ->end()
                    ->arrayNode('article')
                        ->children()
                            ->scalarNode('thumbnail_path')
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ->end();

        return $treeBuilder;
    }
}
