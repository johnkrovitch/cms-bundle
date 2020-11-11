<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use JK\CmsBundle\Entity\Article;
use LAG\AdminBundle\Assets\Registry\ScriptRegistryInterface;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Add helper methods to get media path and directory.
 */
class CmsExtension extends AbstractExtension
{
    private AssetsHelper $assetsHelper;
    private ScriptRegistryInterface $scriptRegistry;
    private ApplicationConfiguration $appConfig;
    private RouterInterface $router;
    private ConfigurationHelper $configurationHelper;
    
    public function __construct(
        AssetsHelper $assetsHelper,
        ScriptRegistryInterface $scriptRegistry,
        ApplicationConfiguration $appConfig,
        RouterInterface $router,
        ConfigurationHelper $configurationHelper
    ) {
        $this->assetsHelper = $assetsHelper;
        $this->scriptRegistry = $scriptRegistry;
        $this->appConfig = $appConfig;
        $this->router = $router;
        $this->configurationHelper = $configurationHelper;
    }

    /**
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('cms_config', [$this, 'cmsConfig']),
            new TwigFunction('cms_article_path', [$this, 'cmsArticlePath']),
        ];
    }

    /**
     * Return the application configuration object from the admin bundle.
     *
     * @return ApplicationConfiguration
     */
    public function cmsConfig(): ApplicationConfiguration
    {
        return $this->appConfig;
    }

    public function cmsArticlePath(Article $article): string
    {
        $route = $this->configurationHelper->getShowRoute();
        $parameters = [];
        $accessor = new PropertyAccessor();

        foreach ($this->configurationHelper->getShowRouteParameters() as $name => $property) {
            if (!$property) {
                $property = $name;
            }
            $parameters[$name] = $accessor->getValue($article, $property);
        }

        return $this->router->generate($route, $parameters);
    }
}
