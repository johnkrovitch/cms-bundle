<?php

namespace JK\CmsBundle\Module\Event;

use JK\CmsBundle\Module\ModuleInterface;
use Symfony\Contracts\EventDispatcher\Event;

class RenderEvent extends Event
{
    private ModuleInterface $module;
    private array $options;
    private string $content;
    
    public function __construct(ModuleInterface $module, array $options = [])
    {
        $this->module = $module;
        $this->options = $options;
    }
    
    public function getModule(): ModuleInterface
    {
        return $this->module;
    }
    
    public function getOptions(): array
    {
        return $this->options;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
