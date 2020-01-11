<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Form\Handler\AddCommentHandler;
use JK\CmsBundle\Form\Type\AddCommentType;
use JK\CmsBundle\Manager\ArticleManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ShowAction
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var AddCommentHandler
     */
    private $handler;

    /**
     * @var ArticleManagerInterface
     */
    private $manager;

    public function __construct(
        Environment $environment,
        ArticleManagerInterface $manager,
        AddCommentHandler $handler,
        FormFactoryInterface $formFactory
    ) {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
        $this->handler = $handler;
        $this->manager = $manager;
    }

    public function __invoke(Request $request): Response
    {
        $article = $this->manager->getOneBy([
            'slug' => $request->get('slug'),
            'publicationStatus' => Article::PUBLICATION_STATUS_PUBLISHED,
        ]);
        $form = $this->formFactory->create(AddCommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->handle($form->getData(), $article);
        }
        $content = $this->environment->render('@JKCms/Article/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
        ]);

        return new Response($content);
    }
}
