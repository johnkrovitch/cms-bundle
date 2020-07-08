<?php

namespace JK\CmsBundle\Module\Event\Subscriber;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ModuleEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(ModuleManagerInterface $moduleManager, RequestStack $requestStack)
    {
        $this->moduleManager = $moduleManager;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'loadModules',
        ];
    }

    public function loadModules(KernelEvent $event): void
    {
        $this->moduleManager->load($event->getRequest());
    }
}
