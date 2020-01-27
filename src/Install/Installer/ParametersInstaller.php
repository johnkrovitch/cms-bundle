<?php

namespace JK\CmsBundle\Install\Installer;

use Exception;
use JK\CmsBundle\Entity\ParameterGroup;
use JK\CmsBundle\Entity\Parameters;
use JK\CmsBundle\Repository\ParameterGroupRepository;
use JK\CmsBundle\Repository\ParametersRepository;
use Symfony\Component\Yaml\Yaml;

class ParametersInstaller implements InstallerInterface
{
    /**
     * @var ParameterGroupRepository
     */
    private $groupRepository;

    /**
     * @var ParametersRepository
     */
    private $parametersRepository;

    public function __construct(ParameterGroupRepository $groupRepository, ParametersRepository $parametersRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->parametersRepository = $parametersRepository;
    }

    public function install(array $context = []): void
    {
        // TODO dynamic fixtures path
        $fixturesPath = __DIR__.'/../../Resources/fixtures/parameters/defaults.yaml';
        $fixtures = Yaml::parse(file_get_contents($fixturesPath));

        foreach ($fixtures['groups'] as $groupData) {
            $group = $this->groupRepository->findOneBy([
                'name' => $groupData['name'],
            ]);

            if (null !== $group && !$context['force']) {
                continue;
            }

            if (null === $group) {
                $group = new ParameterGroup();
            }
            $group->setName($groupData['name']);
            $group->setLabel($groupData['label']);
            $group->setDescription($groupData['description']);

            $this->groupRepository->save($group);
        }

        foreach ($fixtures['parameters'] as $parameterData) {
            $group = $this->groupRepository->findOneBy([
                'name' => $parameterData['group'],
            ]);

            if (!$group instanceof ParameterGroup) {
                throw new Exception('Invalid group name "'.$parameterData['group'].'"');
            }
            $parameter = $this->parametersRepository->findOneBy([
                'name' => $parameterData['name'],
            ]);

            if (null !== $parameter && !$context['force']) {
                continue;
            }

            if (null === $parameter) {
                $parameter = new Parameters();
            }
            $parameter->setGroup($group);
            $parameter->setName($parameterData['name']);
            $parameter->setLabel($parameterData['label']);
            $parameter->setType($parameterData['type']);
            $parameter->setDescription($parameterData['description']);
            $parameter->setValue($parameterData['value'] ?? null);

            $this->parametersRepository->save($parameter);
        }
    }

    public function getName(): string
    {
        return 'parameters';
    }

    public function getDescription(): string
    {
        return 'Install default parameters and parameters groups in database';
    }
}
