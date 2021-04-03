<?php

namespace JK\CmsBundle\Module\Modules\Search;

use JK\CmsBundle\Form\Type\ArticleSearchType;
use JK\CmsBundle\Module\AbstractModule;
use JK\CmsBundle\Module\View\ModuleView;
use JK\CmsBundle\Module\ViewableModuleInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchModule extends AbstractModule implements ViewableModuleInterface
{
    private FormFactoryInterface $formFactory;
    private FormInterface $form;
    private string $route;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getName(): string
    {
        return 'search';
    }

    public function configure(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('route')
            ->setRequired('template')
            ->setAllowedTypes('route', 'string')
            ->setAllowedTypes('template', 'string')
            ->setDefaults([
                'placeholder' => 'cms.article.search',
            ])
        ;
    }

    public function load(Request $request, array $options = []): void
    {
        $this->form = $this->formFactory->create(ArticleSearchType::class, null, [
            'placeholder' => $this->options['placeholder'],
        ]);
        $this->form->handleRequest($request);
        $this->route = $this->options['route'];
    }

    public function getZones(): array
    {
        return [];
    }

    public function createView(string $view = null, array $options = []): ModuleView
    {
        return new ModuleView('@JKCms/modules/search/show.html.twig', [
            'form' => $this->form->createView(),
            'search_route' => $this->route,
        ]);
    }
}
