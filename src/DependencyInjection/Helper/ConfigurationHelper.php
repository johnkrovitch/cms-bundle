<?php

namespace JK\CmsBundle\DependencyInjection\Helper;

class ConfigurationHelper
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getMailingBaseTemplate(): string
    {
        return $this->config['email']['base_template'];
    }

    public function getApplicationName(): string
    {
        return $this->config['application']['name'];
    }

    public function getShowRoute(): string
    {
        return $this->config['application']['articles']['show_route'];
    }

    public function getShowRouteParameters(): array
    {
        return $this->config['application']['articles']['show_route_parameters'];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
