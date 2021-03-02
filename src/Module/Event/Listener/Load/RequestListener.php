<?php

namespace JK\CmsBundle\Module\Event\Listener\Load;

use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class RequestListener
{
    private ModuleManagerInterface $manager;
    
    public function __construct(ModuleManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function __invoke(KernelEvent $event): void
    {
        $this->manager->load($event->getRequest(), []);
    }
}
