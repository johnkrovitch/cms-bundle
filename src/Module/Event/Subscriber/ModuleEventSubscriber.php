<?php

namespace JK\CmsBundle\Module\Event\Subscriber;

use JK\CmsBundle\Event\CmsEvents;
use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ModuleEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    public function __construct(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            CmsEvents::MODULE_LOAD => 'loadModules',
        ];
    }

    public function loadModules(GenericEvent $event): void
    {
        $this->moduleManager->load();
    }
}
