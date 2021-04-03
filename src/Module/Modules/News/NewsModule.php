<?php

namespace JK\CmsBundle\Module\Modules\News;

use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\View\ModuleView;
use JK\CmsBundle\Module\ViewableModuleInterface;
use JK\CmsBundle\Module\Zone\Zone;
use JK\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsModule extends AbstractModule implements ViewableModuleInterface
{
    private ArticleRepository $articleRepository;
    private array$articles = [];

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getName(): string
    {
        return 'news';
    }

    public function configure(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('category')
            ->setAllowedTypes('category', 'string')
            ->setDefaults([
                'limit' => 5,
            ])
            ->setAllowedTypes('limit', 'integer')
        ;
    }

    public function load(Request $request, array $options = []): void
    {
        $this->articles = $this
            ->articleRepository
            ->findPublishedByCategory($this->options['category'], $this->options['limit'])
            ->toArray()
        ;
    }

    public function createView(string $view = null, array $options = []): ModuleView
    {
        return new ModuleView('@JKCms/modules/news/show.html.twig', [
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
