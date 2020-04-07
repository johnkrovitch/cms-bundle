<?php

namespace JK\CmsBundle\Controller\ParameterGroup;

use JK\CmsBundle\Repository\ParameterGroupRepository;
use LAG\AdminBundle\Factory\AdminFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListAction
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var ParameterGroupRepository
     */
    private $repository;

    /**
     * @var AdminFactory
     */
    private $adminFactory;

    public function __construct(
        Environment $environment,
        ParameterGroupRepository $repository,
        AdminFactory $adminFactory
    ) {
        $this->environment = $environment;
        $this->repository = $repository;
        $this->adminFactory = $adminFactory;
    }

    public function __invoke(Request $request): Response
    {
        $admin = $this->adminFactory->createFromRequest($request);
        $admin->handleRequest($request);

        return new Response($this->environment->render('@JKCms/ParameterGroup/list.html.twig', [
            'admin' => $admin->createView(),
            'groups' => $admin->getEntities(),
        ]));
    }
}
