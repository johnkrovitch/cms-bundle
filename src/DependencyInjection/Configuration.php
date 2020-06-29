<?php

namespace JK\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('jk_cms');
        $builder = $treeBuilder->getRootNode()->children();

        $this->configureApplicationNode($builder);
        $this->configureEmailNode($builder);
        $this->configureScriptsNode($builder);
        $this->configureRecaptchaNode($builder);
        $this->configureAdminNode($builder);
        $this->configureArticleNode($builder);
        $this->configureMenuNode($builder);

        return $treeBuilder;
    }

    private function configureApplicationNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('application')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('name')
                        ->defaultValue('JK CmsBundle')
                    ->end()
                    ->scalarNode('front_base')
                        ->defaultValue('base.html.twig')
                    ->end()
                    ->arrayNode('comments')
                        ->children()
                            ->scalarNode('show_route')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('show_route_parameters')
                                ->scalarPrototype()
                                ->defaultValue([])
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('articles')
                        ->children()
                            ->scalarNode('show_route')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('show_route_parameters')
                                ->scalarPrototype()
                                ->defaultValue([])
                                ->end()
                            ->end()
                            ->scalarNode('preview_route')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('show_route_parameters')
                                ->scalarPrototype()
                                ->defaultValue(['id' => 'article.id'])
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function configureEmailNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('email')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('base_template')->defaultValue('@JKCms/Mail/base.html.twig')->end()
                    ->scalarNode('contact_email')->defaultValue('admin@admin.com')->end()
                ->end()
            ->end()
        ;
    }

    private function configureScriptsNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('scripts')
                ->addDefaultsIfNotSet()
                ->children()
                   ->scalarNode('template')->defaultValue('@JKCms/Assets/script.template.html.twig')->end()
                ->end()
            ->end()
        ;
    }

    private function configureAdminNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('admin')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('title')->defaultValue('CMS Admin')->end()
                    ->scalarNode('description')->defaultValue('Administration of the CMS')->end()
                    ->scalarNode('routing_name_pattern')->defaultValue('cms.{admin}.{action}')->end()
                    ->scalarNode('routing_url_pattern')->defaultValue('/{admin}/{action}')->end()
                    ->scalarNode('date_format')->defaultValue('Y-m-d')->end()
                    ->scalarNode('base_template')->defaultValue('@JKCms/base.html.twig')->end()
                    ->scalarNode('homepage_route')->defaultValue('cms.homepage')->end()
                    ->arrayNode('translation')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->scalarNode('pattern')->defaultValue('cms.{admin}.{key}')->end()
                            ->scalarNode('catalog')->defaultValue('messages')->end()
                        ->end()
                    ->end()
                    ->integerNode('max_per_page')->defaultValue(25)->end()
                ->end()
            ->end()
        ;
    }

    private function configureRecaptchaNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('recaptcha')
                ->children()
                   ->scalarNode('site_key')->end()
                   ->scalarNode('secret')->end()
                ->end()
            ->end()
        ;
    }

    private function configureArticleNode(NodeBuilder $builder): void
    {
        $builder
            ->arrayNode('article')
                ->children()
                   ->scalarNode('thumbnail_path')->end()
                ->end()
            ->end()
        ;
    }

    private function configureMenuNode(NodeBuilder $builder): void
    {
        $builder
            ->variableNode('menus')
            ->end()
        ;
    }
}
