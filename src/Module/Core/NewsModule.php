<?php

namespace JK\CmsBundle\Module\Core;

use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\Zone\Zone;
use JK\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;

class NewsModule extends AbstractModule
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    private $articles;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getName(): string
    {
        return 'news';
    }

    public function load(Request $request): void
    {
        $this->articles = $this->articleRepository->findByCategory('breves-de-comptoir', 5);
    }

    public function render(): ModuleView
    {
        return new ModuleView('@JKCms/Modules/news.html.twig', [
            'articles' => $this->articles,
        ]);
    }

    public function getZones(): array
    {
        return [
            Zone::LEFT_COLUMN,
        ];
    }
}
