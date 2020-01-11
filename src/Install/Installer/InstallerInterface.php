<?php

namespace JK\CmsBundle\Install\Installer;

interface InstallerInterface
{
    public function install(array $context = []): void;

    public function getName(): string;

    public function getDescription(): string;
}
