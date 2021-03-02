<?php

namespace JK\CmsBundle\Module\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class LoadModulesEvent extends Event
{
    private Request $request;
    private array $options;
    
    public function __construct(Request $request, array $options = [])
    {
        $this->request = $request;
        $this->options = $options;
    }
    
    public function getRequest(): Request
    {
        return $this->request;
    }
    
    public function getOptions(): array
    {
        return $this->options;
    }
}
