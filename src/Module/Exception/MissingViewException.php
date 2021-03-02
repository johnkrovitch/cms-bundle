<?php

namespace JK\CmsBundle\Module\Exception;

use Exception;

class MissingViewException extends Exception
{
    public function __construct(string $moduleName, string $view)
    {
        parent::__construct(sprintf(
            'The view "%s" does not exists for the module "%s"',
            $moduleName,
            $view
        ));
    }
}
