<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\User;
use JK\CmsBundle\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return User::class;
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
