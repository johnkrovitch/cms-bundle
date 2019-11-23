<?php

namespace JK\CmsBundle\Entity;

use Gedmo\Timestampable\Traits\Timestampable;

class Module
{
    use Timestampable;

    protected $id;

    protected $name = '';

    protected $enabled = '';

    protected $createdAt;
}
