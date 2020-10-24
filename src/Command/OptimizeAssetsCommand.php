<?php

namespace JK\CmsBundle\Command;

use ImageOptimizer\OptimizerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Finder;

class OptimizeAssetsCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected static $defaultName = 'cms:assets:optimize';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $imagesDirectory = $this->container->getParameter('kernel.project_dir').'/public/images';
        $uploadsDirectory = $this->container->getParameter('kernel.project_dir').'/public/uploads';

        if (!file_exists($imagesDirectory)) {
            mkdir($imagesDirectory);
        }

        if (!file_exists($uploadsDirectory)) {
            mkdir($uploadsDirectory);
        }

        $style = new SymfonyStyle($input, $output);
        $style->title('CMS - Optimize Assets');
        $assetsDirectories = [
            $imagesDirectory,
            $uploadsDirectory,
        ];

        $finder = new Finder();
        $finder
            ->in($assetsDirectories)
            ->files()
            ->name('*.jpg')
            ->name('*.png')
        ;
        $factory = new OptimizerFactory();
        $optimizer = $factory->get();

        foreach ($finder as $file) {
            $style->text('Optimize '.$file->getRealPath());
            $optimizer->optimize($file->getRealPath());
        }
        $style->success('Assets optimized');

        return self::SUCCESS;
    }
}
