<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractModule implements ModuleInterface
{
    protected $loaded = false;

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

    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    public function load(Request $request, array $options = []): void
    {
    }
}
