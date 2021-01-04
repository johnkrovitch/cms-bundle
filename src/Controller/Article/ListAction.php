<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Filter\Handler\RequestFilterHandlerInterface;
use JK\CmsBundle\Repository\ArticleRepository;
use JK\CmsBundle\Repository\CategoryRepository;
use LAG\AdminBundle\Factory\AdminFormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ListAction
{
    private Environment $twig;
    private AdminFormFactoryInterface $formFactory;
    private ArticleRepository $articleRepository;
    private CategoryRepository $categoryRepository;
    private RequestFilterHandlerInterface $filterHandler;

    public function __construct(
        Environment $twig,
        AdminFormFactoryInterface $formFactory,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        RequestFilterHandlerInterface $filterHandler
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->filterHandler = $filterHandler;
    }

    public function __invoke(Request $request): Response
    {
        $filters = $this->filterHandler->handle($request);
        $pager = $this->articleRepository->findByFilters($filters);

        $content = $this->twig->render('@JKCms/Article/list.html.twig', [
            'pager' => $pager,
            'title' => $this->getPageTitle($request),
        ]);

        return new Response($content);
    }

    private function getPageTitle(Request $request): string
    {
        $title = 'app.search';

        if ($request->attributes->has('categorySlug')) {
            $category = $this->categoryRepository->findOneBy([
                'slug' => $request->attributes->get('categorySlug'),
            ]);

            if (null === $category) {
                throw new NotFoundHttpException();
            }
            $title = $category->getName();
        }

        return $title;
    }
}
