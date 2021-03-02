<?php

namespace JK\CmsBundle\Controller\Article;

use JK\CmsBundle\Manager\ArticleManagerInterface;
use JK\CmsBundle\Module\Manager\ModuleManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class PreviewAction
{
    private Security $security;
    private ModuleManagerInterface $moduleManager;

    public function __construct(
        Security $security,
        ModuleManagerInterface $moduleManager
    ) {
        $this->security = $security;
        $this->moduleManager = $moduleManager;
    }

    public function __invoke(Request $request): Response
    {
        $module = $this->moduleManager->get('article');
        $module->load($request);
        
        if ($this->security->isGranted(['ROLE_USER'], $this->security->getUser())) {
            throw new AccessDeniedException();
        }

        return new Response($this->moduleManager->render('article', [
            'view' => 'preview',
        ]));
    }
}
