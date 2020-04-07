<?php

namespace JK\CmsBundle\Module\Modules\Parameter\Twig\Extension;

use JK\CmsBundle\Exception\Exception;
use JK\CmsBundle\Repository\ParametersRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ParameterExtension extends AbstractExtension
{
    /**
     * @var ParametersRepository
     */
    private $repository;

    public function __construct(ParametersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('cms_parameter', [$this, 'getParameter']),
        ];
    }

    public function getParameter(string $name)
    {
        $parameter = $this->repository->findOneBy([
            'name' => $name,
        ]);

        if (null === $parameter) {
            throw new Exception('The parameter "'.$name.'" does not exists');
        }

        return $parameter->getValue();
    }
}
