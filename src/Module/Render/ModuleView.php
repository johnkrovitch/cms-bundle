<?php

namespace JK\CmsBundle\Module\Render;

class ModuleView
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(string $template, array $parameters = [])
    {
        $this->template = $template;
        $this->parameters = $parameters;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
