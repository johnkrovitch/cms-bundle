<?php

namespace JK\CmsBundle\Module\Modules\Sync\Command;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Module\Modules\Sync\Event\SyncExportEvent;
use JK\CmsBundle\Module\Modules\Sync\Manager\SyncManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SyncExportCommand extends Command
{
    protected static $defaultName = 'cms:sync:export';

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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Export sync elements');

        $event = new SyncExportEvent();
        $this->eventDispatcher->dispatch($event, SyncExportEvent::NAME);
        $items = $event->getItems();

        $io->note('Found '.count($items).' items to sync...');
        $data = [];

        foreach ($items as $item) {
            if (key_exists($item->getSyncIdentifier(), $data)) {
                throw new Exception('A sync element with id "'.$item->getSyncIdentifier().'" can only be exported once');
            }
            $this->manager->export($item);
        }

        $io->success('Sync elements have been exported');

        return 0;
    }
}
