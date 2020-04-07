<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Module\RenderModuleInterface;
use LogicException;

class ModuleRepository
{
    /**
     * @var RenderModuleInterface[]
     */
    private $modules = [];

    /**
     * @param $zone
     *
     * @return RenderModuleInterface[]
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

    public function addModule(RenderModuleInterface $module)
    {
        if (array_key_exists($module->getName(), $this->modules)) {
            throw new LogicException('Trying to add the module "'.$module->getName().'" twice.');
        }
        $this->modules[$module->getName()] = $module;
    }

    /**
     * @param $name
     *
     * @return RenderModuleInterface
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->modules)) {
            throw new LogicException('Module "'.$name.'" not found');
        }

        return $this->modules[$name];
    }
}
