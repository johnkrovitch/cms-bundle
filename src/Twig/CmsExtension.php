<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Assets\ScriptRegistry;
use JK\CmsBundle\Entity\Article;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use LAG\AdminBundle\Configuration\ApplicationConfigurationStorage;
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
     * @var ScriptRegistry
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
     * CmsExtension constructor.
     */
    public function __construct(
        AssetsHelper $assetsHelper,
        ScriptRegistry $scriptRegistry,
        ApplicationConfigurationStorage $applicationConfigurationStorage,
        RouterInterface $router
    ) {
        $this->assetsHelper = $assetsHelper;
        $this->scriptRegistry = $scriptRegistry;
        $this->applicationConfigurationStorage = $applicationConfigurationStorage;
        $this->router = $router;
    }

    /**
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('cms_dump_scripts', [$this, 'cmsDumpScripts']),
            new TwigFunction('cms_config', [$this, 'cmsConfig']),
            new TwigFunction('cms_article_path', [$this, 'cmsArticlePath']),
        ];
    }

    /**
     * Dump the scripts according to the location (head or footer).
     *
     * @param string $location
     *
     * @return string
     */
    public function cmsDumpScripts($location)
    {
        return $this
            ->scriptRegistry
            ->dumpScripts($location)
        ;
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
        return $this->router->generate('lecomptoir.article.show', [
            'year' => $article->getYear(),
            'month' => $article->getMonth(),
            'slug' => $article->getSlug(),
        ]);
    }
}
