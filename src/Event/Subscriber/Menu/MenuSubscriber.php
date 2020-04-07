<?php

namespace JK\CmsBundle\Event\Subscriber\Menu;

use LAG\AdminBundle\Event\Events;
use LAG\AdminBundle\Event\Menu\MenuConfigurationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            Events::MENU_CONFIGURATION => 'addMenu',
        ];
    }

    public function addMenu(MenuConfigurationEvent $event): void
    {
        return;
        $menus = $event->getMenuConfigurations();

        $menus['left'] = [
            'items' => [
                [
                    'text' => 'cms.menu.articles',
                    'admin' => 'article',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.categories',
                    'admin' => 'category',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.comments',
                    'admin' => 'comment',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.tags',
                    'admin' => 'tag',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.media',
                    'admin' => 'media',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.pages',
                    'admin' => 'page',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.menus',
                    'admin' => 'menu',
                    'action' => 'list',
                ],
                [
                    'text' => 'cms.menu.parameters',
                    'admin' => 'parameters',
                    'action' => 'list',
                ],

                [
                    'text' => 'cms.menu.users',
                    'admin' => 'user',
                    'action' => 'list',
                ],
            ],
        ];

        $event->setMenuConfigurations($menus);
    }
}
