<?php

namespace JK\CmsBundle\Command\Installation;

use JK\CmsBundle\Install\InstallerRegistry\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'cms:install';

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(Registry $registry)
    {
        parent::__construct(self::$defaultName);
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this
            ->setDescription('Install basic fixtures to start with the Cms')
            ->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Force installer to execute (force copying files...)', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Welcome to the Cms installation');
        $context['force'] = (bool) $input->getOption('force');

        $io->note('Running installers...');
        $installers = $this->registry->all();

        foreach ($installers as $installer) {
            $io->note('Run '.$installer->getName().'('.$installer->getDescription().')');
            $installer->install($context);
        }
    }
}
