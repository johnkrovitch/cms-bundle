<?php

namespace JK\CmsBundle\Tests\Kernel;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use JK\CmsBundle\JKCmsBundle;
use JK\CmsBundle\Tests\DependencyInjection\PublicServicePass;
use JK\MediaBundle\JKMediaBundle;
use JK\NotificationBundle\JKNotificationBundle;
use Knp\Bundle\MenuBundle\KnpMenuBundle;
use LAG\AdminBundle\LAGAdminBundle;
use Liip\ImagineBundle\LiipImagineBundle;
use Oneup\UploaderBundle\OneupUploaderBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PublicServicePass());
    }

    public function registerBundles()
    {
        $bundles = [
            // Dependencies
            new FrameworkBundle(),
            new SecurityBundle(),
            new DoctrineBundle(),
            new TwigBundle(),
            new SensioFrameworkExtraBundle(),

            // My Bundle to test
            new LAGAdminBundle(),
            new JKCmsBundle(),
            new JKNotificationBundle(),
            new JKMediaBundle(),
            new LiipImagineBundle(),
            new KnpMenuBundle(),
        ];

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // We don't need that Environment stuff, just one config
        $loader->load(__DIR__.'/../Fixtures/config/config.yaml');
        $loader->load(__DIR__.'/../../../src/Resources/config/services.yaml');
    }
}
