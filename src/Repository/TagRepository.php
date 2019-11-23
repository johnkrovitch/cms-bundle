<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\Tag;
use JK\CmsBundle\Repository\AbstractRepository;

class TagRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return Tag::class;
    }
}
