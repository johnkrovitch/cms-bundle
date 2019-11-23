<?php

namespace JK\CmsBundle\Repository;

use App\Entity\Content;
use JK\CmsBundle\Repository\AbstractRepository;

class ContentRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return Content::class;
    }
}
