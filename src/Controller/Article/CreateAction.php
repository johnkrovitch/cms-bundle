<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Repository\ArticleRepository;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use LAG\AdminBundle\DataPersister\Registry\DataPersisterRegistryInterface;
use LAG\AdminBundle\Factory\AdminFactory;
use LAG\AdminBundle\Routing\RoutingLoader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreateAction
{
    private RouterInterface $router;
    private ArticleRepository $repository;
    private ApplicationConfiguration $appConfig;
    private TranslatorInterface $translator;
    
    public function __construct(
        ArticleRepository $repository,
        ApplicationConfiguration $appConfig,
        TranslatorInterface $translator,
        RouterInterface $router
    ) {
        $this->repository = $repository;
        $this->appConfig = $appConfig;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * When creating a new article, issues with media library and TinyMce can appear as the Article entity has no
     * primary key. So we save it with a default title to avoid issues.
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): Response
    {
        $article = new Article();
        $article->setPublicationStatus(Article::PUBLICATION_STATUS_DRAFT);
        $article->setTitle($this->translator->trans('cms.article.default_title'));
        
        $this->repository->save($article);
    
        $route = $this->appConfig->getRouteName('article', 'edit');
        
        return new RedirectResponse($this->router->generate($route, ['id' => $article->getId()]));
    }
}
