<?php

namespace JK\CmsBundle\Assets;

use JK\CmsBundle\Exception\Exception;
use JK\MediaBundle\Entity\MediaInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\RouterInterface;

class AssetsHelper
{
    /**
     * @var array
     */
    private $assetsMapping;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var CacheManager
     */
    private $assetsManager;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * AssetsHelper constructor.
     *
     * @param string          $kernelEnvironment
     * @param array           $assetsMapping
     * @param RouterInterface $router
     * @param CacheManager    $assetsManager
     * @param string          $rootDirectory
     */
    public function __construct(
        string $kernelEnvironment,
        array $assetsMapping,
        RouterInterface $router,
        CacheManager $assetsManager,
        $rootDirectory
    ) {
        $this->assetsMapping = $assetsMapping;

        if ([] === $this->assetsMapping) {
            $this->assetsMapping = [
                'gallery' => '/uploads/gallery',
            ];
        }
        $this->router = $router;
        $this->environment = $kernelEnvironment;
        $this->assetsManager = $assetsManager;
        $this->rootDir = $rootDirectory;
    }

    /**
     * Return the web path to a Media. If $cache is true, it returns the web path to the cached version.
     *
     * @param MediaInterface $media
     * @param bool           $absolute
     * @param bool           $cache
     * @param string|null    $mediaFilter
     *
     * @return string
     *
     * @throws Exception
     */
    public function getMediaPath(MediaInterface $media, $absolute = true, $cache = true, $mediaFilter = null)
    {
        if (!array_key_exists($media->getType(), $this->assetsMapping)) {
            throw new Exception('No assets mapping found for media type '.$media->getType());
        }

        if (null === $mediaFilter) {
            $mediaFilter = $media->getType();
        }

        $relativePath = sprintf(
            '%s/%s',
            $this->assetsMapping[$media->getType()],
            $media->getFileName()
        );
        $path = $relativePath;

        if (true === $absolute) {
            $context = $this
                ->router
                ->getContext();
            $path = $context->getScheme().'://'.$context->getHost().'/'.$path;

            // bug fix for development environment
            if ('prod' !== $this->environment) {
                $path = str_replace('app_'.$this->environment.'.php', '', $path);
            }
        }

        if ($cache) {
            $path = $this
                ->assetsManager
                ->getBrowserPath($relativePath, $mediaFilter);
        }

        return $path;
    }

    /**
     * Return the web directory according to the given mapping name. The mapping name should exists.
     *
     * @param string $mappingName
     *
     * @return string
     *
     * @throws Exception
     */
    public function getMediaDirectory($mappingName)
    {
        if (!array_key_exists($mappingName, $this->assetsMapping)) {
            throw new Exception('No assets mapping found for media type '.$mappingName);
        }

        return $this->assetsMapping[$mappingName];
    }

    /**
     * Upload a file into a media directory according to the mapping. Update the media entity with the new file data.
     *
     * @param MediaInterface $media
     * @param UploadedFile   $file
     */
    public function uploadAsset(MediaInterface $media, UploadedFile $file)
    {
        $fileSystem = new Filesystem();
        $filename = urlencode($file->getClientOriginalName());
        $directory = $this->getMediaDirectory($media->getType());

        // if a asset with the same name exists in the same directory, we generate a random file name
        if ($fileSystem->exists($this->getWebDirectory().'/'.$directory.'/'.$filename)) {
            $filename = uniqid('assets-').'.'.$file->getClientOriginalExtension();
        }
        // define the media attributes values
        $media->setFileName($filename);
        $media->setFileType($file->getClientOriginalExtension());
        $media->setSize($file->getSize());

        // move the uploaded files to the given directory
        $file->move($this->getWebDirectory().'/'.$directory, $media->getFileName());
    }

    public function createFromFile(UploadedFile $file)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Return the web directory. It should exists or an Exception is thrown.
     *
     * @return string
     *
     * @throws Exception
     */
    protected function getWebDirectory()
    {
        $fileSystem = new Filesystem();
        $webDirectory = realpath($this->rootDir.'/../web');

        // web directory must be found
        if (!$fileSystem->exists($webDirectory)) {
            throw new Exception('Web directory not found');
        }

        return $webDirectory;
    }
}
