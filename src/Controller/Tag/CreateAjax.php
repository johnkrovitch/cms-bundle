<?php

namespace JK\CmsBundle\Controller\Tag;

use JK\CmsBundle\Entity\Tag;
use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Repository\TagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateAjax
{
    /**
     * @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $value = $request->get('value');

        if (!$value) {
            throw new Exception('Invalid value');
        }
        $tag = new Tag();
        $tag->setName(ucfirst($value));

        $this->repository->save($tag);

        return new JsonResponse([
            'id' => $tag->getId(),
            'name' => $tag->getName(),
        ]);
    }
}
