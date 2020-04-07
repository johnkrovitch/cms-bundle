<?php

namespace JK\CmsBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JK\CmsBundle\Entity\ParameterGroup;
use JK\Repository\AbstractRepository;

class ParameterGroupRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return ParameterGroup::class;
    }

    public function findAllWithParameters(): Collection
    {
        $result = $this
            ->createQueryBuilder('parameter_group')
            ->addSelect('parameters')
            ->leftJoin('parameter_group.parameters', 'parameters')
            ->addOrderBy('parameter_group.position', 'ASC')
            ->addOrderBy('parameters.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return new ArrayCollection($result);
    }
}
