<?php

namespace JK\CmsBundle\DependencyInjection\Helper;

use LAG\AdminBundle\Configuration\ApplicationConfiguration;

class ConfigurationHelper
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ApplicationConfiguration
     */
    private $application;

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
}
