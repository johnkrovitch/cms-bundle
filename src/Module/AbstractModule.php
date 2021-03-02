<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\Exception\MissingOptionsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractModule implements ModuleInterface
{
    protected bool $loaded = false;
    protected array $options;

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

    public function setOptions(array $options): void
    {
        if ($this->isConfigured()) {
            throw new Exception('The module "'.$this->getName().'" is already configured');
        }
        $this->options = $options;
    }

    public function getOptions(): array
    {
        $this->assertIsConfigured();

        return $this->options;
    }
    
    public function hasOption(string $option): bool
    {
        $this->assertIsConfigured();
    
        return key_exists($option, $this->options);
    }
    
    public function getOption(string $option)
    {
        $this->assertIsConfigured();
    
        if (!$this->hasOption($option)) {
            throw new MissingOptionsException($option, $this->getName());
        }
    
        return $this->options[$option];
    }
    
    public function isConfigured(): bool
    {
        return isset($this->options);
    }

    public function configure(OptionsResolver $resolver): void
    {
    }

    public function load(Request $request, array $options = []): void
    {
    }
    
    protected function assertIsConfigured(): void
    {
        if (!$this->isConfigured()) {
            throw new Exception('The module "'.$this->getName().'" is not configured');
        }
    }
    
    protected function configureViews(array $views, OptionsResolver $resolver): void
    {
        foreach ($views as $view) {
        
        }
    }
}
