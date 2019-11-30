<?php

namespace JK\CmsBundle\Controller\Notification;

use JK\NotificationBundle\Manager\NotificationManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MarkAsRead
{
    /**
     * @var NotificationManagerInterface
     */
    private $manager;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(NotificationManagerInterface $manager, RouterInterface $router)
    {
        $this->manager = $manager;
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        $notification = $this->manager->get((int) $request->get('id'));
        $this->manager->markAsRead($notification);

        return new RedirectResponse($this->router->generate('cms.dashboard'));
    }
}
