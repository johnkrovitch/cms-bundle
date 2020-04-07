<?php

namespace JK\CmsBundle\Module\Modules\Parameter\Event\Subscriber;

use JK\CmsBundle\Entity\Parameters;
use JK\CmsBundle\Module\Modules\Sync\Event\SyncExportEvent;
use JK\CmsBundle\Module\Modules\Sync\Event\SyncImportEvent;
use JK\CmsBundle\Module\Modules\Sync\SyncableInterface;
use JK\CmsBundle\Repository\ParametersRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Import and export parameters from yaml files to database records using the sync module.
 */
class ParameterEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ParametersRepository
     */
    private $repository;

    public function __construct(ParametersRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SyncExportEvent::NAME => 'export',
            SyncImportEvent::NAME => 'import',
        ];
    }

    public function export(SyncExportEvent $event): void
    {
        $parameters = $this->repository->findAll();

        foreach ($parameters as $parameter) {
            if (!$parameter instanceof SyncableInterface) {
                continue;
            }
            $event->addItem($parameter);
        }
    }

    public function import(SyncImportEvent $event): void
    {
        $items = $event->getItemsByGroup('parameters');

        foreach ($items as $item) {
            if (!$item instanceof SyncableInterface) {
                continue;
            }
            $data = $item->exportSync();

            if (!key_exists('name', $data)) {
                continue;
            }
            $parameter = $this->repository->findOneBy([
                'name' => $data['name'],
            ]);

            if (null === $parameter) {
                $parameter = new Parameters();
            }
            $parameter->importSync($data);
            $this->repository->save($parameter);
        }
    }
}
