<?php

namespace JK\CmsBundle\Routing\Loader;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

class RoutingLoader implements LoaderInterface
{
    public function load($resource, string $type = null)
    {

    }

    public function supports($resource, string $type = null): bool
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
        // TODO: Implement getResolver() method.
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // TODO: Implement setResolver() method.
    }
}
