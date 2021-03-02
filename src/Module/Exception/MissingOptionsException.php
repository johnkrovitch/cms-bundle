<?php

namespace JK\CmsBundle\Module\Exception;

use JK\CmsBundle\Exception\Exception;

class MissingOptionsException extends Exception
{
    public function __construct(string $option, string $module)
    {
        $message = sprintf('The option "%s" does not exists in the module "%s"', $option, $module);
        
        parent::__construct($message);
    }
}
