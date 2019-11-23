<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Exception\Exception;
use LAG\AdminBundle\Factory\AdminFactory;
use LAG\AdminBundle\Factory\DataProviderFactory;
use LAG\AdminBundle\Routing\RoutingLoader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreateArticleAction
{
    /**
     * @var AdminFactory
     */
    private $adminFactory;

    /**
     * @var DataProviderFactory
     */
    private $dataProviderFactory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * AdminAction constructor.
     *
     * @param AdminFactory        $adminFactory
     * @param DataProviderFactory $dataProviderFactory
     * @param TranslatorInterface $translator
     * @param RouterInterface     $router
     */
    public function __construct(
        AdminFactory $adminFactory,
        DataProviderFactory $dataProviderFactory,
        TranslatorInterface $translator,
        RouterInterface $router
    ) {
        $this->adminFactory = $adminFactory;
        $this->dataProviderFactory = $dataProviderFactory;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * When creating a new article, issues with media library and TinyMce can appear as the Article entity has no
     * primary key. So we save it with a default title to avoid issues.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        // Handle the current request
        $admin = $this->adminFactory->createFromRequest($request);
        $admin->handleRequest($request);

        $dataProvider = $this->dataProviderFactory->get($admin->getConfiguration()->get('data_provider'));

        // Set a new title and save the article to avoid problem with missing primary key when using the media library
        $entity = $dataProvider->create($admin);
        $entity->setPublicationStatus(Article::PUBLICATION_STATUS_DRAFT);
        $entity->setTitle($this->translator->trans('cms.article.default_title'));

        $admin->getEntities()->add($entity);

        $dataProvider->save($admin);

        if (key_exists('edit', $admin->getConfiguration()->get('actions'))) {
            $actionToRedirect = 'edit';
        } elseif (key_exists('list', $admin->getConfiguration()->get('actions'))) {
            $actionToRedirect = 'list';
        } else {
            throw new Exception("Unable to find an action to redirect to for the admin {$admin->getName()}");
        }

        $route = RoutingLoader::generateRouteName(
            $admin->getName(),
            $actionToRedirect,
            $admin->getConfiguration()->get('routing_name_pattern')
        );
        $url = $this->router->generate($route, [
            'id' => $entity->getId(),
        ]);

        return new RedirectResponse($url);
    }
}
