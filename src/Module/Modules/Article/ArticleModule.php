<?php

namespace JK\CmsBundle\Module\Modules\Article;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Manager\ArticleManagerInterface;
use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\Exception\MissingViewException;
use JK\CmsBundle\Module\View\ModuleView;
use JK\CmsBundle\Module\ViewableModuleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleModule extends AbstractModule implements ViewableModuleInterface
{
    private ArticleManagerInterface $manager;
    private Article $article;
    
    public function __construct(ArticleManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function getName(): string
    {
        return 'article';
    }

    public function configure(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('preview', function (OptionsResolver $previewResolver) {
                $previewResolver
                    ->setRequired('template')
                    ->setAllowedTypes('template', 'string')
                ;
            })
            ->addAllowedTypes('preview', 'array')
        ;
    }
    
    public function load(Request $request, array $options = []): void
    {
        $this->article = $this->manager->get($request->get('slug'));
    }
    
    public function createView(string $view = null, array $options = []): ModuleView
    {
        if ($view === 'preview') {
            return new ModuleView($this->getOption('preview')['template'], [
                'article' => $this->article,
            ]);
        }
        throw new MissingViewException($this->getName(), $view);
    }
}
