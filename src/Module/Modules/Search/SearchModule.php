<?php

namespace JK\CmsBundle\Module\Modules\Search;

use JK\CmsBundle\Form\Type\SearchType;
use JK\CmsBundle\Module\AbstractFrontModule;
use JK\CmsBundle\Module\Render\ModuleView;
use JK\CmsBundle\Module\RenderModuleInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchModule extends AbstractFrontModule implements RenderModuleInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var string
     */
    private $route;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getName(): string
    {
        return 'search';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('route')
            ->setAllowedTypes('route', 'string')
            ->setDefaults([
                'placeholder' => 'cms.article.search',
            ])
        ;
    }

    public function load(Request $request, array $options = []): void
    {
        $this->form = $this->formFactory->create(SearchType::class, null, [
            'placeholder' => $options['placeholder'],
        ]);
        $this->form->handleRequest($request);
        $this->route = $options['route'];
    }

    public function getZones(): array
    {
        return [];
    }

    public function render(array $options = []): ModuleView
    {
        return new ModuleView('@JKCms/modules/search/show.html.twig', [
            'form' => $this->form->createView(),
            'search_route' => $this->route,
        ]);
    }
}
