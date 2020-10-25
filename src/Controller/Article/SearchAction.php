<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Form\Type\ArticleSearchType;
use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use JK\CmsBundle\Module\Modules\Search\Finder\ArticleFinderInterface;
use JK\CmsBundle\Module\Modules\Search\Finder\Request\RequestParameterExtractorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SearchAction
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ArticleFinderInterface
     */
    private $finder;

    /**
     * @var RequestParameterExtractorInterface
     */
    private $extractor;

    public function __construct(
        Environment $environment,
        ModuleManagerInterface $moduleManager,
        FormFactoryInterface $formFactory,
        ArticleFinderInterface $finder,
        RequestParameterExtractorInterface $extractor
    ) {
        $this->environment = $environment;
        $this->moduleManager = $moduleManager;
        $this->formFactory = $formFactory;
        $this->finder = $finder;
        $this->extractor = $extractor;
    }

    public function __invoke(Request $request): Response
    {
        $configuration = $this->moduleManager->get('search')->getConfiguration();
        $page = $request->query->getInt('page', 1);
        $form = $this->formFactory->create(ArticleSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $articles = $this->finder->findByTerms(explode(' ', $data['search'], $page));
            $search = $data['search'];
        } else {
            $filters = $this->extractor->extract($request);
            $articles = $this->finder->findByFilter($filters, $page);
            $search = (count($filters) > 0) ? array_shift($filters) : '';
        }

        return new Response($this->environment->render($configuration['template'], [
            'articles' => $articles,
            'title' => 'app.search.title',
            'search' => $search,
        ]));
    }
}
