<?php

namespace JK\CmsBundle\Assets\Uploader;

use Exception;
use JK\CmsBundle\Entity\Article;
use JK\MediaBundle\Entity\MediaInterface;
use JK\MediaBundle\Form\Type\MediaType;
use JK\MediaBundle\Repository\MediaRepository;
use JK\MediaBundle\Repository\MediaRepositoryInterface;
use LAG\Component\StringUtils\StringUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * @var string
     */
    private $uploadDirectory;

    /**
     * @var string
     */
    private $cacheDirectory;

    /**
     * Uploader constructor.
     *
     * @param string $uploadDirectory
     * @param string $cacheDirectory
     */
    public function __construct(
        $uploadDirectory,
        $cacheDirectory,
        MediaRepositoryInterface $mediaRepository
    ) {
        $this->uploadDirectory = $uploadDirectory;
        $this->mediaRepository = $mediaRepository;
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * @return MediaInterface
     *
     * @throws Exception
     */
    public function upload(array $data, Article $article = null)
    {
        $media = null;

        if (MediaType::UPLOAD_FROM_COMPUTER === $data['uploadType']) {
            if ($data instanceof UploadedFile) {
                // upload done in php
                $media = $this->uploadFile($data);
            } elseif ($data['upload'] instanceof MediaInterface) {
                // upload done in ajax
                $media = $data['upload'];
            }
        } elseif (MediaType::UPLOAD_FROM_URL === $data['uploadType']) {
        } elseif (MediaType::CHOOSE_FROM_COLLECTION === $data['uploadType']) {
            // find from the repository with the selected id
            $media = $this
                ->mediaRepository
                ->find($data['gallery'])
            ;
        }

        // a media has to be found at this point
        if (null === $media) {
            throw new Exception('Unable to retrieve an media object from the upload data');
        }

        return $media;
    }

    protected function uploadFile(UploadedFile $file, Article $article = null)
    {
        $media = $this
            ->mediaRepository
            ->create()
        ;
        $name = $this->generateFileName($file->getClientOriginalExtension(), $article);
        $media->setName($name);
        $media->setFileName($name);
        $media->setFileType($file->getClientOriginalExtension());
        $media->setType('upload');
        $media->setSize($file->getSize());

        $file->move($this->uploadDirectory, $name);
        $this
            ->mediaRepository
            ->save($media)
        ;

        return $media;
    }

    public function uploadFromUrl($url)
    {
        if (!is_string($url) || !$url) {
            throw new Exception('Invalid url "'.$url.'" for file upload');
        }
        $content = file_get_contents($url);
        $temporaryFile = $this->cacheDirectory.'/uploads/'.uniqid();

        file_put_contents($temporaryFile, $content);
        $size = getimagesize($temporaryFile);

        if ($size <= 0) {
            throw new Exception('Cannot fetch image from url "'.$url.'"');
        }
    }

    /**
     * Generate an unique default file name.
     *
     * @param string $extension
     *
     * @return string
     */
    protected function generateFileName($extension, Article $article = null)
    {
        $title = '';

        if (null !== $article) {
            $title = StringUtils::underscore($article->getTitle()).'-';
        }

        return sprintf('%s%s.%s', uniqid('assets-'), $title, $extension);
    }
}
