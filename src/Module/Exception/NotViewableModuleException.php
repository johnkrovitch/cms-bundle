<?php

namespace JK\CmsBundle\Module\Exception;

use Exception;
use JK\CmsBundle\Module\ViewableModuleInterface;

class NotViewableModuleException extends Exception
{
    public function __construct(string $moduleName)
    {
        parent::__construct(sprintf(
            'The module "%s" is not viewable : it should implements "%s"',
            $moduleName,
            ViewableModuleInterface::class)
        );
    }
}
