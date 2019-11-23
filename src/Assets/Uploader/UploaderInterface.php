<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\CmsBundle\Entity\Article;
use JK\MediaBundle\Entity\MediaInterface;

interface UploaderInterface
{
    /**
     * @param              $data
     * @param Article|null $article
     *
     * @return MediaInterface
     */
    public function upload(array $data, Article $article = null);
}
