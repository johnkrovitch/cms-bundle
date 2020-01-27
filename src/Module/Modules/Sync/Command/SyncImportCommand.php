<?php

namespace JK\CmsBundle\Module\Modules\Sync\Command;

use JK\CmsBundle\Module\Modules\Sync\Event\SyncImportEvent;
use JK\CmsBundle\Module\Modules\Sync\Manager\SyncManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SyncImportCommand extends Command
{
    protected static $defaultName = 'cms:sync:import';

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var SyncManagerInterface
     */
    private $manager;

    public function __construct(EventDispatcherInterface $eventDispatcher, SyncManagerInterface $manager)
    {
        parent::__construct(self::$defaultName);
        $this->eventDispatcher = $eventDispatcher;
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this->setDescription('Export configured sync elements');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import sync elements');

        $items = $this->manager->import();
        $syncItems = [];

        foreach ($items as $group => $itemGroup) {
            foreach ($itemGroup as $identifier => $item) {
                $syncItems[] = $this->manager->create($identifier, $group, $item);
            }
        }
        $event = new SyncImportEvent($syncItems);
        $this->eventDispatcher->dispatch($event, SyncImportEvent::NAME);

        $io->success('Sync elements have been imported');
    }
}
