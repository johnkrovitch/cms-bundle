<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\DependencyInjection\Helper\ConfigurationHelper;
use JK\CmsBundle\Entity\Article;
use LAG\AdminBundle\Assets\Registry\ScriptRegistryInterface;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use LAG\AdminBundle\Configuration\ApplicationConfigurationStorage;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Add helper methods to get media path and directory.
 */
class CmsExtension extends AbstractExtension
{
    /**
     * @var AssetsHelper
     */
    private $assetsHelper;

    /**
     * @var ScriptRegistryInterface
     */
    private $scriptRegistry;

    /**
     * @var ApplicationConfigurationStorage
     */
    private $applicationConfigurationStorage;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ConfigurationHelper
     */
    private $configurationHelper;

    /**
     * CmsExtension constructor.
     */
    public function __construct(
        AssetsHelper $assetsHelper,
        ScriptRegistryInterface $scriptRegistry,
        ApplicationConfigurationStorage $applicationConfigurationStorage,
        RouterInterface $router,
        ConfigurationHelper $configurationHelper
    ) {
        $this->assetsHelper = $assetsHelper;
        $this->scriptRegistry = $scriptRegistry;
        $this->applicationConfigurationStorage = $applicationConfigurationStorage;
        $this->router = $router;
        $this->configurationHelper = $configurationHelper;
    }

    /**
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions()
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
    public function cmsConfig()
    {
        return $this->applicationConfigurationStorage->getConfiguration();
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
