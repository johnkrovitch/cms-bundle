<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Manager\CommentManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UnsubscribeAction
{
    /**
     * @var CommentManagerInterface
     */
    private $commentManager;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        CommentManagerInterface $commentManager,
        SessionInterface $session,
        TranslatorInterface $translator,
        RouterInterface $router
    ) {
        $this->commentManager = $commentManager;
        $this->session = $session;
        $this->translator = $translator;
        $this->router = $router;
    }

    public function __invoke(Request $request): Response
    {
        $this
            ->commentManager
            ->unsubscribe($request->get('slug'), $request->get('email'))
        ;
        $this
            ->session
            ->getFlashBag()
            ->add('success', $this->translator->trans('cms.comment.unsubscribe_success'))
        ;

        return new RedirectResponse($this->router->generate('lecomptoir.homepage'));
    }
}
