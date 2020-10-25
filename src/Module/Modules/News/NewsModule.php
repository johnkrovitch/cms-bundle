<?php

namespace JK\CmsBundle\Module\Modules\News;

use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\RenderModuleInterface;
use JK\CmsBundle\Module\Zone\Zone;
use JK\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->findPublishedByCategory($this->configuration['category'], $this->configuration['limit'])
        ;
    }

    public function render(array $options = []): ModuleView
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
