<?php

namespace JK\CmsBundle\Module\Modules\News;

use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\RenderModuleInterface;
use JK\CmsBundle\Module\Zone\Zone;
use JK\CmsBundle\Repository\ArticleRepository;

class NewsModule extends AbstractModule implements RenderModuleInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    private $articles = [];

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getName(): string
    {
        return 'news';
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

    public function load(): void
    {
        $this->articles = $this->articleRepository->findByCategory('breves-de-comptoir', 5);
        $this->loaded = true;
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
