<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Assets\ScriptRegistry;
use JK\CmsBundle\Entity\Article;
use JK\MediaBundle\Entity\MediaInterface;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use LAG\AdminBundle\Configuration\ApplicationConfigurationStorage;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Symfony\Component\Routing\RouterInterface;
use Twig\TwigFunction;

/**
 * Add helper methods to get media path and directory.
 */
class CmsExtension extends TwigExtension
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
     *
     * @param AssetsHelper                    $assetsHelper
     * @param ScriptRegistry                  $scriptRegistry
     * @param ApplicationConfigurationStorage $applicationConfigurationStorage
     * @param RouterInterface                 $router
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
            new TwigFunction('cms_media_path', [$this, 'cmsMediaPath']),
            new TwigFunction('cms_media_directory', [$this, 'cmsMediaDirectory']),
            new TwigFunction('cms_media_size', [$this, 'cmsMediaSize']),
            new TwigFunction('cms_dump_scripts', [$this, 'cmsDumpScripts']),
            new TwigFunction('cms_config', [$this, 'cmsConfig']),
            new TwigFunction('cms_article_path', [$this, 'cmsArticlePath']),
        ];
    }

    /**
     * Return the path to an media according to its type.
     *
     * @param MediaInterface $media
     * @param bool           $absolute
     * @param bool           $cache
     * @param string|null    $mediaFilter
     *
     * @return string
     */
    public function cmsMediaPath(MediaInterface $media, $absolute = true, $cache = true, $mediaFilter = null)
    {
        return $this
            ->assetsHelper
            ->getMediaPath($media, $absolute, $cache, $mediaFilter)
        ;
    }

    /**
     * Return the media web directory according to its type and the mapping.
     *
     * @param string $mappingName
     *
     * @return string
     */
    public function cmsMediaDirectory($mappingName)
    {
        return $this
            ->assetsHelper
            ->getMediaDirectory($mappingName)
        ;
    }

    /**
     * Return a string representing the media size in the most readable unit.
     *
     * @param MediaInterface $media
     *
     * @return string
     */
    public function cmsMediaSize(MediaInterface $media)
    {
        $size = $media->getSize();
        // try size in Kio
        $size = round($size / 1024, 2);

        if ($size >= 1000) {
            $size = round($size / 1024, 2);

            return $size.' Mo';
        }

        return $size.' Ko';
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
