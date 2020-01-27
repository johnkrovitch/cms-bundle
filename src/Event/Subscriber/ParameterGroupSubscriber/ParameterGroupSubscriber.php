<?php

namespace JK\CmsBundle\Event\Subscriber\ParameterGroupSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use JK\CmsBundle\Entity\ParameterGroup;
use JK\CmsBundle\Entity\Parameters;
use JK\CmsBundle\Exception\Exception;
use LAG\AdminBundle\Bridge\Doctrine\ORM\Event\ORMFilterEvent;
use LAG\AdminBundle\Event\Events;
use Pagerfanta\Pagerfanta;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ParameterGroupSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
//            Events::ENTITY_LOAD => [
//                'sort', -255,
//            ],
//            Events::DOCTRINE_ORM_FILTER => 'filter',
        ];
    }

    public function sort(Events\EntityEvent $event)
    {
        return;
        if ('parameters' !== $event->getAdmin()->getName()) {
        }
        $groups = $event->getEntities();

        if ($groups instanceof Pagerfanta) {
            $groups = iterator_to_array($groups->getCurrentPageResults());
        } else {
            $groups = $groups->toArray();
        }

        foreach ($groups as $group) {
            if (!$group instanceof ParameterGroup) {
                throw new Exception();
            }
            $parameters = $group->getParameters()->toArray();

            usort($parameters, function (Parameters $parameter1, Parameters $parameter2) {
                return $parameter1->getPosition() > $parameter2->getPosition();
            });
            $group->setParameters(new ArrayCollection($parameters));
        }

        $event->setEntities($groups);
    }

    public function filter(ORMFilterEvent $event)
    {
        $admin = $event->getAdmin();

        if ('parameters' !== $admin->getName()) {
            return;
        }
        $queryBuilder = $event->getQueryBuilder();
        $alias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->innerJoin($alias.'.parameters', 'parameters')
            ->addOrderBy('parameters.position', 'ASC')
        ;
    }
}
