<?php

namespace JK\CmsBundle\Module\Exception;

use JK\CmsBundle\Exception\Exception;

class EmptyViewException extends Exception
{
    public function __construct()
    {
        parent::__construct('The view is empty');
    }
}
