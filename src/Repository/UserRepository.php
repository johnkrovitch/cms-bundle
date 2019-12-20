<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\User;
use JK\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return User::class;
    }
}
