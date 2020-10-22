<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\MediaBundle\Entity\MediaInterface;

interface UploaderInterface
{
    /**
     * Upload the data from the upload from and create a media.
     */
    public function upload(array $data): MediaInterface;
}
