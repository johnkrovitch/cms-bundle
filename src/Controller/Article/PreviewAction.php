<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Manager\ArticleManagerInterface;
use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class PreviewAction
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var ArticleManagerInterface
     */
    private $manager;

    /**
     * @var ModuleManagerInterface
     */
    private $moduleManager;

    public function __construct(
        Environment $environment,
        ArticleManagerInterface $manager,
        Security $security,
        ModuleManagerInterface $moduleManager
    ) {
        $this->environment = $environment;
        $this->security = $security;
        $this->manager = $manager;
        $this->moduleManager = $moduleManager;
    }

    public function __invoke(Request $request)
    {
        $article = $this->manager->get($request->get('id'));
        $configuration = $this->moduleManager->get('article')->getConfiguration();

        if ($this->security->isGranted('ROLE_USER', $this->security->getUser())) {
            throw new AccessDeniedException();
        }

        return $this->environment->render($configuration['article'], [
            'article' => $article,
        ]);
    }
}
