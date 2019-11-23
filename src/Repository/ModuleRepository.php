<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Module\ModuleInterface;
use LogicException;

class ModuleRepository
{
    /**
     * @var ModuleInterface[]
     */
    private $modules = [];

    /**
     * @param $zone
     *
     * @return ModuleInterface[]
     */
    public function load($zone)
    {
        $modules = [];

        foreach ($this->modules as $module) {
            if (in_array($zone, $module->getZones())) {
                $modules[] = $module;
            }
        }

        return $modules;
    }

    /**
     * @param ModuleInterface $module
     */
    public function addModule(ModuleInterface $module)
    {
        if (array_key_exists($module->getName(), $this->modules)) {
            throw new LogicException('Trying to add the module "'.$module->getName().'" twice.');
        }
        $this->modules[$module->getName()] = $module;
    }

    /**
     * @param $name
     *
     * @return ModuleInterface
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->modules)) {
            throw new LogicException('Module "'.$name.'" not found');
        }

        return $this->modules[$name];
    }
}
