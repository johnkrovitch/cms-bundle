<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\Parameters;
use JK\Repository\AbstractRepository;

class ParametersRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return Parameters::class;
    }
}
