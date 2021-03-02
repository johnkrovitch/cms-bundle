<?php

namespace JK\CmsBundle\Module\Exception;

use Exception;

class NotLoadedException extends Exception
{
    public function __construct(string $moduleName)
    {
        parent::__construct(sprintf('The module "%s" exists but is not loaded', $moduleName));
    }
}
