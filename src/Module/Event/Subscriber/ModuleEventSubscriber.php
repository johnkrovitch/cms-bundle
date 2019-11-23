<?php

namespace JK\CmsBundle\Module\Event\Subscriber;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

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
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();

        $this->moduleManager->load($request);
    }
}
