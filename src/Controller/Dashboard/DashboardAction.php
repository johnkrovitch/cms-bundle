<?php

namespace JK\CmsBundle\Controller\Dashboard;

use DateTime;
use JK\CmsBundle\Entity\User;
use JK\CmsBundle\Repository\ArticleRepository;
use JK\CmsBundle\Repository\CommentRepository;
use JK\NotificationBundle\Repository\NotificationRepository;
use LAG\AdminBundle\Event\Events;
use LAG\AdminBundle\Event\Events\BuildMenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig\Environment;

class DashboardAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * DashboardAction constructor.
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        CommentRepository $commentRepository,
        ArticleRepository $articleRepository,
        NotificationRepository $notificationRepository,
        Environment $twig,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->commentRepository = $commentRepository;
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
        $this->articleRepository = $articleRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function __invoke(): Response
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }
        $newCommentCount = $this
            ->commentRepository
            ->findNewCommentCount($user->getCommentLastViewDate())
        ;
        $lastMonth = new DateTime('first day of last month');

        $lastArticles = $this
            ->articleRepository
            ->findBy([], [
                'updatedAt' => 'desc',
                'id' => 'desc',
            ], 5)
        ;
        $lastComments = $this->commentRepository->findByDate($lastMonth);
        $notifications = $this->notificationRepository->findUnread($user->getId());

        return new Response($this->twig->render('@JKCms/Dashboard/dashboard.html.twig', [
            'newCommentCount' => $newCommentCount,
            'lastArticles' => $lastArticles,
            'lastComments' => $lastComments,
            'notifications' => $notifications,
        ]));
    }
}
