<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractModule implements ModuleInterface
{
    protected $loaded = false;
    protected $configuration;

    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    public function setLoaded(): void
    {
        if ($this->loaded) {
            throw new Exception('The module "'.$this->getName().'" is already loaded');
        }
        $this->loaded = true;
    }

    public function supports(Request $request): bool
    {
        // By default module are enabled only on back-office pages
        return null !== $request->get('_admin');
    }

    public function setConfiguration(array $configuration): void
    {
        if ($this->isConfigured()) {
            throw new Exception('The module "'.$this->getName().'" is already configured');
        }
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        if (!$this->isConfigured()) {
            throw new Exception('The module "'.$this->getName().'" is not configured');
        }

        return $this->configuration;
    }

    public function isConfigured(): bool
    {
        return $this->configuration !== null;
    }

    public function configure(OptionsResolver $resolver): void
    {
    }

    public function load(Request $request, array $options = []): void
    {
    }
}
