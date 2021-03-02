<?php

namespace JK\CmsBundle\Module\Event;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class LoadModuleEvent extends Event
{
    private Request $request;
    private ModuleInterface $module;
    private array $options;
    
    public function __construct(Request $request, ModuleInterface $module, array $options = [])
    {
        $this->request = $request;
        $this->module = $module;
        $this->options = $options;
    }
    
    public function getRequest(): Request
    {
        return $this->request;
    }
    
    public function getModule(): ModuleInterface
    {
        return $this->module;
    }
    
    public function getOptions(): array
    {
        return $this->options;
    }
}
