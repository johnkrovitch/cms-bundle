<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Module\Render\ModuleView;
use Symfony\Component\HttpFoundation\Request;

interface ModuleInterface
{
    public function getName(): string;

    public function load(Request $request): void;

    public function getZones(): array;

    public function supports(Request $request): bool;

    public function render(): ModuleView;
}
